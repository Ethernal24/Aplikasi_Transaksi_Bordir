<?php

namespace app\controllers;

use app\helpers\ModelHelper;
use app\models\Bom;
use app\models\BomCustom;
use app\models\MasterMrp;
use app\models\Mps;
use app\models\MpsDetail;
use app\models\MpsSearch;
use app\models\MrpDetail;
use app\models\PermintaanPelanggan;
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
        $detail = MpsDetail::find()
            ->where(['mps_id' => $mps_id])
            ->all();

        $model = $this->findModel($mps_id);
        return $this->render('view', [
            'model' => $model,
            'detail' => $detail
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
            ->with(['details.produk'])
            ->one();

        if ($permintaan && $permintaan->details) {
            $items = [];
            foreach ($permintaan->details as $d) {
                $items[] = [
                    'barang_id'   => $d->produk_id, // Dari model PermintaanDetail
                    'nama_barang' => $d->produk ? $d->produk->nama_barang : 'Tanpa Nama', // Dari relasi getProduk()
                    'qty'         => $d->jumlah, // Sesuaikan jika nama kolomnya 'jumlah' atau 'qty'
                ];
            }
            return ['items' => $items];
        }

        return ['items' => []]; // Kembalikan array kosong jika tidak ada
    }
}
