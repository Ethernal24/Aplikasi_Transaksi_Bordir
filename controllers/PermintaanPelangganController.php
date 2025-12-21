<?php

namespace app\controllers;

use app\helpers\ModelHelper;
use app\models\BomCustom;
use app\models\MasterPelanggan;
use app\models\Mps;
use app\models\MpsDetail;
use app\models\PermintaanDetail;
use app\models\PermintaanPelanggan;
use app\models\PermintaanPelangganSearch;
use app\models\ProdukCustomPelanggan;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Model;

/**
 * PermintaanPelangganController implements the CRUD actions for PermintaanPelanggan model.
 */
class PermintaanPelangganController extends Controller
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
     * Lists all PermintaanPelanggan models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PermintaanPelangganSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PermintaanPelanggan model.
     * @param int $permintaan_id Permintaan ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($permintaan_id)
    {
        $model = $this->findModel($permintaan_id);
        $detail = $model->details;
        if (empty($detail)) {
            Yii::info('Data Details Tidak ditemukan untuk permintaan_id: $permintaan_id');
        }
        return $this->render('view', [
            'detail' => $detail,
            'model' => $this->findModel($permintaan_id),
        ]);
    }

    /**
     * Creates a new PermintaanPelanggan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new PermintaanPelanggan();
        $modelDetails = [new PermintaanDetail()];

        // Generate kode (Saran: pindahkan ke model jika ingin lebih rapi)
        $last = PermintaanPelanggan::find()
            ->select('kode_permintaan')
            ->orderBy(['permintaan_id' => SORT_DESC])
            ->one();

        $nextnumber = $last ? ((int) str_replace('SO-', '', $last->kode_permintaan) + 1) : 1;
        $model->kode_permintaan = 'SO-' . str_pad($nextnumber, 3, '0', STR_PAD_LEFT);

        if ($model->load($this->request->post())) {
            $modelDetails = ModelHelper::createMultiple(PermintaanDetail::class);
            Model::loadMultiple($modelDetails, $this->request->post());

            // Validasi Header & Detail
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelDetails) && $valid;

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($model->save(false)) {
                        foreach ($modelDetails as $i => $detail) {
                            $detail->permintaan_id = $model->permintaan_id;
                            if (!$detail->save(false)) {
                                $transaction->rollBack();
                                Yii::$app->session->setFlash('error', "Gagal simpan detail ke-" . ($i + 1));;
                                break;
                            }
                        }

                        // Update tanggal pesanan terakhir pelanggan
                        $pelanggan = MasterPelanggan::findOne($model->pelanggan_id);
                        if ($pelanggan) {
                            $pelanggan->pesenan_terakhir = $model->tanggal_permintaan;
                            $pelanggan->save(false);
                        }

                        // Jalankan fungsi tambahan (MPS)
                        // $this->createMps($model);

                        $transaction->commit();
                        Yii::$app->session->setFlash('success', "Permintaan berhasil disimpan.");
                        return $this->redirect(['view', 'permintaan_id' => $model->permintaan_id]);
                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', "Error: " . $e->getMessage());
                }
            } else {
                // Jika validasi gagal, tampilkan pesan ke user
                Yii::$app->session->setFlash('error', "Data tidak valid. Periksa kembali inputan Anda.");
            }
        }

        return $this->render('create', [
            'model' => $model,
            'modelDetails' => (empty($modelDetails)) ? [new PermintaanDetail()] : $modelDetails
        ]);
    }

    /**
     * Updates an existing PermintaanPelanggan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $permintaan_id Permintaan ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($permintaan_id)
    {
        $model = $this->findModel($permintaan_id);
        $modelDetails = $model->details;

        // Simpan nilai lama master
        $oldTanggal = $model->tanggal_permintaan;
        $oldTenggat = $model->tenggat_waktu;

        $post = Yii::$app->request->post();
        if ($model->load($post)) {
            // Pertahankan tanggal lama jika input kosong
            $model->tanggal_permintaan = $model->tanggal_permintaan ?: $oldTanggal;
            $model->tenggat_waktu = $model->tenggat_waktu ?: $oldTenggat;

            // Ambil ID detail lama
            $oldIDs = ArrayHelper::getColumn($modelDetails, 'id');

            // Ambil data POST detail
            $detailPost = isset($post['PermintaanDetail']) ? $post['PermintaanDetail'] : [];
            $modelDetailsNew = [];

            foreach ($detailPost as $i => $detailData) {
                if (!empty($detailData['id'])) {
                    // ambil model existing
                    $detailModel = PermintaanDetail::findOne($detailData['id']);
                    if (!$detailModel) $detailModel = new PermintaanDetail();
                } else {
                    $detailModel = new PermintaanDetail();
                }
                $detailModel->load(['PermintaanDetail' => $detailData]);
                $modelDetailsNew[] = $detailModel;
            }

            $deletedIDs = array_diff($oldIDs, ArrayHelper::getColumn($modelDetailsNew, 'id'));

            // Validasi
            $valid = $model->validate() && Model::validateMultiple($modelDetailsNew);

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $model->save(false);

                    if (!empty($deletedIDs)) {
                        PermintaanDetail::deleteAll(['id' => $deletedIDs]);
                    }

                    foreach ($modelDetailsNew as $detail) {
                        $detail->permintaan_id = $model->permintaan_id;
                        $detail->save(false);
                    }

                    $transaction->commit();
                    return $this->redirect(['view', 'permintaan_id' => $model->permintaan_id]);
                } catch (\Throwable $e) {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', 'Terjadi kesalahan: ' . $e->getMessage());
                }
            } else {
                Yii::$app->session->setFlash('error', 'Validasi gagal.');
            }

            $modelDetails = $modelDetailsNew;
        }

        return $this->render('update', [
            'model' => $model,
            'modelDetails' => empty($modelDetails) ? [new PermintaanDetail()] : $modelDetails,
        ]);
    }



    /**
     * Deletes an existing PermintaanPelanggan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $permintaan_id Permintaan ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($permintaan_id)
    {
        $this->findModel($permintaan_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PermintaanPelanggan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $permintaan_id Permintaan ID
     * @return PermintaanPelanggan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($permintaan_id)
    {
        if (($model = PermintaanPelanggan::findOne(['permintaan_id' => $permintaan_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGetBarangByPelanggan($pelanggan_id)
    {
        $produks = ProdukCustomPelanggan::find()
            ->where(['pelanggan_id' => $pelanggan_id])
            ->all();

        if ($produks) {
            echo "<option value=''>Pilih Barang</option>";
            foreach ($produks as $p) {
                echo "<option value='{$p->produk_custom_pelanggan_id}'>" . htmlspecialchars($p->nama_barang_custom) . "</option>";
            }
        } else {
            echo "<option value=''>Tidak ada barang</option>";
        }
    }

    public function createMps($permintaan)
    {
        foreach ($permintaan->details as $detail) {
            $mps = new Mps();
            // Tentukan tipe barang
            $mps->barang_id = $detail->produk_custom_pelanggan_id;
            $mps->tipe = 1;
            $mps->periode = Yii::$app->formatter->asDate($permintaan->tanggal_permintaan, 'php: Y-m-d');
            $mps->tanggal_awal = Yii::$app->formatter->asDate($permintaan->tanggal_permintaan, 'php: Y-m-d');
            $mps->qty = $detail->jumlah;
            $mps->sumber = $permintaan->permintaan_id;
            $mps->dateline = $permintaan->tenggat_waktu; // atau tenggat waktu
            $mps->status_mps = 0;
            $mps->save(false);
        }
    }
}
