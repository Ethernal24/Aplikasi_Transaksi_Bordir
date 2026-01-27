<?php

namespace app\controllers;

use app\models\PermintaanDetail;
use app\models\PermintaanPelanggan;
use app\models\ProductionLog;
use app\models\RoutingDetail;
use app\models\WorkOrder;
use app\models\WorkOrderSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * WorkOrderController implements the CRUD actions for WorkOrder model.
 */
class WorkOrderController extends Controller
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
     * Lists all WorkOrder models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new WorkOrderSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WorkOrder model.
     * @param int $id_wo Id Wo
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_wo)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_wo),
        ]);
    }

    /**
     * Creates a new WorkOrder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new WorkOrder();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['index']);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing WorkOrder model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_wo Id Wo
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_wo)
    {
        $model = $this->findModel($id_wo);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing WorkOrder model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_wo Id Wo
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_wo)
    {
        $this->findModel($id_wo)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the WorkOrder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_wo Id Wo
     * @return WorkOrder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_wo)
    {
        if (($model = WorkOrder::findOne(['id_wo' => $id_wo])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGetBarang($id)
    {
        // 1. Ambil data Header
        $header = PermintaanPelanggan::findOne($id);
        $dueDate = $header ? $header->tenggat_waktu : '';

        // 2. Ambil data Detail
        $details = PermintaanDetail::find()
            ->where(['permintaan_id' => $id])
            ->all();

        $options = "<option value=''>Pilih Barang...</option>";
        $dataKatalog = [];

        // Periksa apakah data ada dan tidak kosong
        if (!empty($details)) {
            foreach ($details as $item) {
                // Gunakan null coalescing atau check relasi agar tidak error jika produk null
                $namaBarang = isset($item->produk) ? $item->produk->nama_barang : "Produk tidak dikenal";

                $options .= "<option value='" . $item->permintaan_detail_id . "'>" . $namaBarang . "</option>";

                $dataKatalog[$item->permintaan_detail_id] = [
                    'qty' => $item->jumlah,
                    'duedate' => $dueDate
                ];
            }
        } else {
            // Jika detail kosong, berikan opsi keterangan kosong
            $options = "<option value=''>- Tidak ada barang untuk permintaan ini -</option>";
        }

        return Json::encode([
            'html' => $options,
            'katalog' => $dataKatalog
        ]);
    }
    protected function generateLogNumber()
    {
        $prefix = 'Log-' . date('Ym') . '-';
        $lastWo = ProductionLog::find()
            ->where(['like', 'kode_log', $prefix . '%', false])
            ->orderBy(['id_log' => SORT_DESC])
            ->one();

        if ($lastWo) {
            $lastNumber = (int) substr($lastWo->kode_log, -4);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return $prefix . $newNumber;
    }
    public function actionStartProduction($id_wo)
    {
        $wo = $this->findModel($id_wo);

        // 1. Cari tahap terakhir yang sudah tercatat di ProductionLog untuk WO ini
        $lastLog = ProductionLog::find()
            ->where(['id_wo' => $id_wo])
            ->orderBy(['id_log' => SORT_DESC])
            ->one();

        // 2. Cari tahap berikutnya di RoutingDetail
        if (!$lastLog) {
            // Jika belum ada log sama sekali, ambil urutan pertama (Tahap 1)
            $nextRouting = RoutingDetail::find()
                ->where(['routing_id' => $wo->id_routing])
                ->orderBy(['urutan' => SORT_ASC])
                ->one();
        } else {
            // Jika sudah ada log sebelumnya, cari urutan yang LEBIH BESAR dari urutan terakhir
            // Kita butuh tahu urutan ke berapa dari routing_id yang sekarang sedang jalan
            $currentUrutan = RoutingDetail::find()
                ->where(['routing_id' => $wo->id_routing, 'workcenter_id' => $lastLog->id_workcenter])
                ->one();

            $nextRouting = RoutingDetail::find()
                ->where(['routing_id' => $wo->id_routing])
                ->andWhere(['>', 'urutan', $currentUrutan ? $currentUrutan->urutan : 0])
                ->orderBy(['urutan' => SORT_ASC])
                ->one();
        }

        // Cek apakah masih ada tahap selanjutnya
        if (!$nextRouting) {
            Yii::$app->session->setFlash('warning', "Semua tahapan routing untuk WO ini sudah selesai.");
            return $this->redirect(['view', 'id_wo' => $id_wo]);
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $newNumber = $this->generateLogNumber();

            $logHeader = new ProductionLog();
            $logHeader->kode_log = $newNumber;
            $logHeader->tanggal = date('Y-m-d');
            // Sekarang id_workcenter akan mengikuti tahap urutan berikutnya
            $logHeader->id_workcenter = $nextRouting->workcenter_id;
            $logHeader->id_wo = $wo->id_wo;
            $logHeader->status = 0;
            $logHeader->id_shift = $wo->mps->shift->shift_id;

            if (!$logHeader->save()) {
                throw new \Exception("Gagal membuat Log Header: " . json_encode($logHeader->getErrors()));
            }

            $wo->status_wo = 1; // In-Progress
            $wo->save(false);

            $transaction->commit();
            Yii::$app->session->setFlash('success', "Memulai produksi untuk tahap: " . $nextRouting->workCenter->nama_workcenter);

            return $this->redirect(['production-log/view', 'id_log' => $logHeader->id_log]);
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', "Error: " . $e->getMessage());
            return $this->redirect(['view', 'id_wo' => $id_wo]);
        }
    }

    public function actionFinishProduction($id_log)
    {
        $model = ProductionLog::findOne($id_log);
        if (!$model) {
            throw new NotFoundHttpException("Log tidak ditemukan.");
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model->status = 2; // Selesai
            // Gunakan save(false) untuk memastikan status log tersimpan meskipun ada field lain yang kosong
            if (!$model->save(false)) {
                throw new \Exception("Gagal menyimpan status log.");
            }

            // Pastikan relasi 'idWo' ada di model ProductionLog
            $workOrder = $model->wo;

            if ($workOrder) {
                $routingSekarang = RoutingDetail::find()
                    ->where([
                        'routing_id' => $workOrder->id_routing,
                        'workcenter_id' => $model->id_workcenter
                    ])
                    ->one();

                if ($routingSekarang) {
                    $isLastStep = !RoutingDetail::find()
                        ->where(['routing_id' => $workOrder->id_routing])
                        ->andWhere(['>', 'urutan', $routingSekarang->urutan])
                        ->exists();

                    if ($isLastStep) {
                        $workOrder->status_wo = 2; // WO Selesai Total
                        $workOrder->save(false); // Simpan tanpa validasi untuk memastikan status berubah

                        $so = PermintaanPelanggan::findOne($workOrder->permintaan_id);
                        if ($so) {
                            $isAllWoFinished = !workOrder::find()
                                ->where(['permintaan_id' => $so->permintaan_id])
                                ->andWhere(['!=', 'status_wo', 2])
                                ->exists();
                            if ($isAllWoFinished) {
                                $so->status_pesanan = 2; // Sesuaikan dengan label/ID status Anda
                                if (!$so->save(false)) throw new \Exception("Gagal update status SO.");
                                Yii::$app->session->setFlash('success', "Seluruh proses produksi selesai. Status SO ditutup.");
                            } else {
                                Yii::$app->session->setFlash('info', "WO selesai, namun masih ada item lain dalam SO ini yang dalam proses.");
                            }
                        }
                    }
                }
            }

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', "Gagal: " . $e->getMessage());
        }

        return $this->redirect(['view', 'id_wo' => $model->id_wo]);
    }
}
