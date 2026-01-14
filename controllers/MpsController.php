<?php

namespace app\controllers;

use app\helpers\ModelHelper;
use app\models\Bom;
use app\models\BomCustom;
use app\models\MasterMrp;
use app\models\Mesin;
use app\models\Mps;
use app\models\MpsDetail;
use app\models\MpsSearch;
use app\models\MrpDetail;
use app\models\PermintaanPelanggan;
use app\models\Shift;
use app\models\TenagaKerja;
use app\models\Workcenter;
use app\models\Workorder;
use app\models\WorkorderMaterial;
use DateTime;
use Yii;
use yii\base\Model;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * MpsController implements the CRUD actions for Mps model.
 */
class MpsController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Mps models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MpsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Mps model.
     * @param int $mps_id Mps ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($mps_id)
    {
        $model = $this->findModel($mps_id);
        $detail = MpsDetail::find()->where(['mps_id' => $mps_id])->all();

        // Panggil fungsi internal (bukan actionGetCapacity)
        $capacityData = $this->calculateCapacityData($model->tanggal_awal, $model->tanggal_akhir, $model->shift_id);

        return $this->render('view', [
            'model' => $model,
            'detail' => $detail,
            'capacityData' => $capacityData,
        ]);
    }
    /**
     * Creates a new Mps model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Mps();
        $modelsDetail = [new MpsDetail()];

        $model->kode_mps = $model->generateAutoNumber('MPS', 'kode_mps');

        if ($this->request->isPost) {
            $model->load($this->request->post());

            // 1. Ambil data detail dari POST menggunakan Model Helper
            $modelsDetail = ModelHelper::createMultiple(MpsDetail::classname());
            Model::loadMultiple($modelsDetail, $this->request->post());

            // 2. Validasi semua model (Header & Semua Detail)
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsDetail) && $valid;

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    // 3. Simpan Header terlebih dahulu
                    if ($flag = $model->save(false)) {
                        foreach ($modelsDetail as $modelDetail) {
                            // 4. INI KUNCINYA: Hubungkan ID Header yang baru saja disimpan ke Detail
                            $modelDetail->mps_id = $model->mps_id;

                            if (!($flag = $modelDetail->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'mps_id' => $model->mps_id]);
                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', 'Terjadi kesalahan: ' . $e->getMessage());
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'modelDetails' => $modelsDetail
        ]);
    }

    /**
     * Updates an existing Mps model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $mps_id Mps ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($mps_id)
    {
        $model = $this->findModel($mps_id);
        $modelsDetail = $model->mpsDetails; // Mengambil relasi hasMany Anda

        if ($this->request->isPost) {
            $model->load($this->request->post());

            // 1. Ambil ID detail yang ada saat ini untuk pengecekan hapus
            $oldIDs = ArrayHelper::map($modelsDetail, 'mps_detail_id', 'mps_detail_id');

            // 2. Load data dari post ke multiple model
            $modelsDetail = ModelHelper::createMultiple(MpsDetail::classname(), $modelsDetail);
            Model::loadMultiple($modelsDetail, $this->request->post());

            // 3. Ambil ID yang baru saja di-load dari form
            $newIDs = ArrayHelper::map($modelsDetail, 'mps_detail_id', 'mps_detail_id');
            $deletedIDs = array_diff($oldIDs, $newIDs);

            // Validasi
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsDetail) && $valid;

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        // 4. Hapus data detail yang tidak ada lagi di form
                        if (!empty($deletedIDs)) {
                            MpsDetail::deleteAll(['mps_detail_id' => $deletedIDs]);
                        }

                        // 5. Simpan/Update detail
                        foreach ($modelsDetail as $modelDetail) {
                            $modelDetail->mps_id = $model->mps_id;
                            if (! ($flag = $modelDetail->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'mps_id' => $model->mps_id]);
                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', $e->getMessage());
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'modelDetails' => (empty($modelsDetail)) ? [new MpsDetail] : $modelsDetail
        ]);
    }

    /**
     * Deletes an existing Mps model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $mps_id Mps ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($mps_id)
    {
        $this->findModel($mps_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Mps model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $mps_id Mps ID
     * @return Mps the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($mps_id)
    {
        if (($model = Mps::findOne(['mps_id' => $mps_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGetPermintaan($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;


        // Mengambil data PermintaanPelanggan beserta relasi 'details' dan relasi 'produk' di dalamnya
        $permintaan = PermintaanPelanggan::find()
            ->where(['permintaan_id' => $id])
            ->with(['details.produk.routing.details'])
            ->one();

        if ($permintaan && $permintaan->details) {
            $items = [];
            foreach ($permintaan->details as $d) {
                $routingDetails = [];
                $totalSmv = 0; // Inisialisasi counter total menit

                if ($d->produk && $d->produk->routing && $d->produk->routing->details) {
                    foreach ($d->produk->routing->details as $rd) {
                        // Masukkan ke array untuk kalkulasi per Workcenter di JS
                        $routingDetails[] = [
                            'wc_id'   => $rd->workcenter_id,
                            'smv'     => (float) $rd->waktu_standar,
                            'setup'   => (float) $rd->waktu_setup,
                        ];
                        // Tambahkan ke total untuk kebutuhan display ringkas
                        $totalSmv += (float) $rd->waktu_standar;
                    }
                }

                $items[] = [
                    'barang_id'       => $d->produk_id,
                    'nama_barang'     => $d->produk ? $d->produk->nama_barang : 'Tanpa Nama',
                    'qty'             => $d->jumlah,
                    'routing_details' => $routingDetails, // Penting untuk box per workcenter
                    'smv'             => $totalSmv > 0 ? $totalSmv : 25, // Pakai hasil jumlah atau fallback 25
                ];
            }
            return [
                'items' => $items,
                'due_date' => $permintaan->tenggat_waktu
            ];
        }

        return ['items' => []]; // Kembalikan array kosong jika tidak ada
    }

    public static function getManPowerCapacity($startDate, $endDate, $shiftId, $workcenterId = null)
    {
        $days = (new DateTime($endDate))->diff(new DateTime($startDate))->days + 1;
        $shift = Shift::findOne($shiftId);
        $dailyMinutes = $shift ? ($shift->jam_efektif * 60) : 480;

        $tk = TenagaKerja::find()->where(['status_kerja' => 0]);
        if ($workcenterId) {
            $tk->andWhere(['workcenter_id' => $workcenterId]); // Perbaikan: hapus tanda kutip
        }

        $hitungPekerja = $tk->count();
        return $hitungPekerja * $dailyMinutes;
    }

    public static function getMachineCapacity($startDate, $endDate, $shiftId, $workcenterId = null)
    {
        $shift = Shift::findOne($shiftId);
        $dailyMinutes = $shift ? ($shift->jam_efektif * 60) : 480;

        $query = Mesin::find()->where(['status_mesin' => 0]);
        if ($workcenterId) {
            $query->andWhere(['workcenter_id' => $workcenterId]);
        }
        $hitungJumlahMesin = $query->count();

        // Jika ada kolom power_factor di tabel Mesin, gunakan sum, jika tidak gunakan count
        // $totalPower = $query->sum('power_factor') ?: $query->count();

        return $hitungJumlahMesin * $dailyMinutes;
    }

    protected function calculateCapacityData($start, $end, $shiftId)
    {
        $days = (new DateTime($end))->diff(new DateTime($start))->days + 1;
        $workcenters = Workcenter::find()->all();
        $data = [];
        $shift = Shift::findOne($shiftId);
        $durationMenit = $shift ? ($shift->jam_efektif * 60) : 480;
        foreach ($workcenters as $wc) {
            $data[$wc->workcenter_id] = [
                'nama' => $wc->nama_workcenter,
                'tipe_kapasitas' => $wc->tipe_kapasitas,
                // Memanggil fungsi static yang sudah Anda buat
                'cap_man_daily' => self::getManPowerCapacity($start, $end, $shiftId, $wc->workcenter_id),
                'cap_man' => self::getManPowerCapacity($start, $end, $shiftId, $wc->workcenter_id) * $days,
                'cap_machine_daily' => self::getMachineCapacity($start, $end, $shiftId, $wc->workcenter_id),
                'cap_machine' => self::getMachineCapacity($start, $end, $shiftId, $wc->workcenter_id) * $days,
            ];
        }
        return [
            'workcenters' => $data,
            'shift_duration' => $durationMenit,
        ];
    }

    protected function calcualatePowerCapacity($start, $end, $shiftId) {}

    // --- Update Action AJAX Anda ---
    public function actionGetCapacity($start, $end, $shiftId)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $this->calculateCapacityData($start, $end, $shiftId);
    }
    protected function generateWoNumber()
    {
        $prefix = 'WO-' . date('Ym') . '-';
        $lastWo = WorkOrder::find()
            ->where(['like', 'kode_wo', $prefix . '%', false])
            ->orderBy(['id_wo' => SORT_DESC])
            ->one();

        if ($lastWo) {
            $lastNumber = (int) substr($lastWo->kode_wo, -4);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return $prefix . $newNumber;
    }

    public function actionVerify($mps_id)
    {
        $model = $this->findModel($mps_id);
        $model->status_mps = 1;

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if (!$model->save(false)) throw new \Exception("Gagal update MPS.");

            foreach ($model->mpsDetails as $detail) {
                // Logika Penomoran (Sama seperti sebelumnya)
                $newNumber = $this->generateWoNumber();

                $wo = new WorkOrder();
                $wo->kode_wo = $newNumber;
                $wo->id_mps = $mps_id;
                $wo->permintaan_id = $detail->permintaan->permintaan_id;
                $wo->id_produk = $detail->produk_id;
                $wo->qty_target = $detail->qty_plan;
                $wo->tanggal_wo = date('Y-m-d');
                $wo->due_date = $detail->estimasi_selesai;
                $wo->status_wo = 0;
                $wo->prioritas = $model->prioritas;
                $wo->id_routing = $detail->routing->routing_id ?? null;
                $wo->save(false);
                if ($wo->save()) {
                    // PANGGIL FUNGSI TERPISAH UNTUK MATERIAL
                    $this->generateWoMaterials($wo->id_wo, $detail->mps_id, $detail->produk_id);
                } else {
                    throw new \Exception("Gagal membuat Header WO.");
                }
            }

            $transaction->commit();
            Yii::$app->session->setFlash('success', "MPS Verified. WO Header & Materials created.");
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['view', 'mps_id' => $mps_id]);
    }

    protected function generateWoMaterials($id_wo, $mps_id, $produk_id)
    {
        // 1. Cari Header MRP terkait MPS ini
        $mrp = MasterMrp::findOne(['mps_id' => $mps_id]);

        if (!$mrp) {
            throw new \Exception("Data MRP tidak ditemukan untuk MPS ini. Silakan generate MRP terlebih dahulu.");
        }

        // 2. Ambil detail material dari MRP khusus untuk produk ini
        // Catatan: Pastikan di tabel MRP Detail Anda menyimpan 'product_id' 
        // atau bisa memfilternya melalui relasi BOM.
        $mrpDetails = MrpDetail::find()
            ->where(['mrp_id' => $mrp->mrp_id])
            ->all();

        foreach ($mrpDetails as $mrpItem) {
            // Cek apakah material ini memang bagian dari BOM produk yang sedang diproses
            // Ini penting jika 1 MPS punya banyak produk agar material tidak tertukar
            $isRelated = Bom::find()->where([
                'produk_id' => $produk_id,
                'bahan_id' => $mrpItem->bahan_id
            ])->exists();

            if ($isRelated) {
                $woMat = new WorkorderMaterial();
                $woMat->wo_id = $id_wo;
                $woMat->bahan_id = $mrpItem->bahan_id;

                // Mengambil Qty dari hasil kalkulasi MRP
                $woMat->qty_plan = $mrpItem->kebutuhan_kotor;
                $woMat->qty_aktual = 0;
                $woMat->status_pengambilan_bahan = 0;

                if (!$woMat->save()) {
                    throw new \Exception("Gagal menyalin data MRP ke Material WO ID: $id_wo");
                }
            }
        }
        return true;
    }
    public function actionGenerateMrp($mps_id)
    {
        $model = $this->findModel($mps_id);
        $oldMrp = MasterMrp::findOne(['mps_id' => $mps_id]);

        $mrp = new MasterMrp();
        $prefix = 'MRP-' . date('Ym') . '-';
        $lastMrp = $mrp::find()
            ->where(['like', 'kode_mrp', $prefix])
            ->orderBy(['mrp_id' => SORT_DESC])
            ->one();

        if ($lastMrp) {
            // Ambil 4 angka terakhir, lalu tambah 1
            $lastNumber = (int) substr($lastMrp->kode_mrp, -4);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($oldMrp !== null) {
                $oldMrp->delete();
            }
            $mrp->mps_id = $mps_id;
            $mrp->kode_mrp = $prefix . $newNumber;
            $mrp->status = 0;
            if ($mrp->save()) {
                foreach ($model->mpsDetails as $mpsDetail) {
                    $boms = Bom::find()->where(['produk_id' => $mpsDetail->produk_id])->all();

                    foreach ($boms as $bom) {
                        // Kalkulasi Kebutuhan
                        $totalNeeded = $mpsDetail->qty_plan * $bom->qty_per_unit;

                        // Ambil Stok Saat Ini (Asumsi ada kolom stock di MasterProduct/Material)
                        $material = $bom->bahan; // Relasi ke MasterProduct

                        $mrpDetail = new MrpDetail();
                        $mrpDetail->mrp_id = $mrp->mrp_id;
                        $mrpDetail->bahan_id = $bom->bahan_id;
                        $mrpDetail->kebutuhan_kotor = $totalNeeded;
                        $mrpDetail->stock_tersedia = $material->stock ?? 0;
                        $mrpDetail->kebutuhan_bersih = max(0, $totalNeeded - ($material->stock ?? 0));

                        if (!$mrpDetail->save()) {
                            throw new \Exception("Gagal menyimpan detail MRP untuk material: " . $bom->material_id);
                        }
                    }
                }
                $transaction->commit();
                Yii::$app->session->setFlash('success', "MRP Berhasil dibuat untuk MPS: " . $model->kode_mps);
                return $this->redirect(['/master-mrp/view', 'mrp_id' => $mrp->mrp_id]);
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', "Gagal Generate MRP: " . $e->getMessage());
            return $this->redirect(['view', 'mps_id' => $mps_id]);
        }
    }
}
