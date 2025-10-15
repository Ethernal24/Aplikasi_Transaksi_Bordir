<?php

namespace app\controllers;

use app\helpers\ModelHelper;
use app\models\BomCustom;
use app\models\PermintaanDetail;
use app\models\PermintaanPelanggan;
use app\models\PermintaanPelangganSearch;
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
        foreach ($detail as $details) {
            $bomCustom = $details->bomCustom;
        }
        if (empty($detail)) {
            Yii::info('Data Details Tidak ditemukan untuk permintaan_id: $permintaan_id');
        }
        return $this->render('view', [
            'detail' => $detail,
            'model' => $this->findModel($permintaan_id),
            'bomCustom' => $bomCustom
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


        if ($model->load($this->request->post())) {
            $modelDetails = ModelHelper::createMultiple(PermintaanDetail::class);
            Model::loadMultiple($modelDetails, $this->request->post());
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelDetails) && $valid;

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($model->save(false)) {
                        foreach ($modelDetails as $detail) {
                            $detail->permintaan_id = $model->permintaan_id;
                            if (! $detail->save(false)) {
                                $transaction->rollBack();
                                break;
                            }
                            foreach ($detail->barang->boms as $bom) {
                                $bomCustom = new BomCustom();
                                $bomCustom->permintaan_detail_id = $detail->permintaan_detail_id;
                                $bomCustom->bahan_id = $bom->bahan_id;
                                $bomCustom->qty_per_unit = $bom->qty_per_unit;
                                $bomCustom->unit_id = $bom->unit_id;
                                $bomCustom->save(false);
                            }
                        }
                    }
                    $transaction->commit();
                    return $this->redirect(['view', 'permintaan_id' => $model->permintaan_id]);
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'modelDetails' => $modelDetails
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
        $modelDetails = $model->details; // relasi dari PermintaanPelanggan -> PermintaanDetail

        if ($model->load(Yii::$app->request->post())) {
            $oldIDs = ArrayHelper::map($modelDetails, 'permintaan_id', 'permintaan_id'); // ambil id lama detail
            $modelDetails = ModelHelper::createMultiple(PermintaanDetail::class, $modelDetails);
            Model::loadMultiple($modelDetails, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelDetails, 'id', 'id')));

            // validasi master dan detail
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelDetails) && $valid;

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($model->save(false)) {
                        // hapus data detail yang dihapus dari form
                        if (!empty($deletedIDs)) {
                            PermintaanDetail::deleteAll(['permintaan_id' => $deletedIDs]);
                        }

                        // simpan data detail
                        foreach ($modelDetails as $detail) {
                            $detail->permintaan_id = $model->permintaan_id;
                            if (! $detail->save(false)) {
                                $transaction->rollBack();
                                Yii::error($detail->errors);
                                break;
                            }
                        }

                        $transaction->commit();
                        return $this->redirect(['view', 'permintaan_id' => $model->permintaan_id]);
                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                }
            }
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
}
