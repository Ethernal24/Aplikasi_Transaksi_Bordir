<?php

namespace app\controllers;

use app\models\Bom;
use app\models\BomCustom;
use app\models\MasterMrp;
use app\models\Mps;
use app\models\MpsDetail;
use app\models\MpsSearch;
use app\models\MrpDetail;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'mps_id' => $model->mps_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
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

        if ($this->request->isPost && $model->load($this->request->post())) {
            $isApproved = $model->status_mps == 1;
            if ($model->save()) {
                if ($isApproved) {
                    $existingMrp = MasterMrp::find()->where(['mps_id' => $model->mps_id])->one();
                    if (!$existingMrp) {
                        $mrp = new MasterMrp();
                        $mrp->mps_id = $model->mps_id;
                        $mrp->status = 0;
                        $mrp->save(false);

                        if ($model->tipe == 0) {
                            // MTS → ambil dari tabel BOM tetap
                            $boms = Bom::find()->where(['produk_id' => $model->barang_id])->all();
                        } else {
                            // MTO → ambil dari BOM custom pelanggan
                            $boms = BomCustom::find()->where(['produk_custom_pelanggan_id' => $model->barang_id])->all();
                        }

                        foreach ($boms as $bom) {
                            $detail = new MrpDetail;
                            $detail->mrp_id = $mrp->mrp_id;
                            $detail->bahan_id = $bom->bahan_id;
                            $detail->kebutuhan_kotor = $bom->qty_per_unit * $model->qty;
                            $detail->stock_tersedia = $model->barang->stok;
                            $detail->kebutuhan_bersih = $detail->kebutuhan_kotor - $detail->stock_tersedia;
                            $detail->leadtime = $model->barang->leadtime;
                            $detail->planned_order_receipt = $model->dateline;
                            $detail->planned_order_release = date('Y-m-d', strtotime($detail->planned_order_receipt . "-" . $detail->leadtime));
                            $detail->save(false);
                        }
                    }
                }
            }
            return $this->redirect(['view', 'mps_id' => $model->mps_id]);
        }

        return $this->render('update', [
            'model' => $model,
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
}
