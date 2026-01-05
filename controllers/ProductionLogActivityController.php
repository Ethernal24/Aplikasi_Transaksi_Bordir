<?php

namespace app\controllers;

use app\models\ProductionLog;
use app\models\ProductionLogActivity;
use app\models\ProductionLogActivitySearch;
use app\models\RoutingDetail;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductionLogActivityController implements the CRUD actions for ProductionLogActivity model.
 */
class ProductionLogActivityController extends Controller
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
     * Lists all ProductionLogActivity models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProductionLogActivitySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductionLogActivity model.
     * @param int $activity_id Activity ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($activity_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($activity_id),
        ]);
    }

    /**
     * Creates a new ProductionLogActivity model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($id_log)
    {
        $model = new ProductionLogActivity();
        $model->id_log = $id_log;

        // Ambil data Header untuk tahu Produk dan Workcenter-nya
        $header = ProductionLog::findOne($id_log);
        $wo = $header->wo; // Asumsi relasi ke WO ada

        // Cari Routing Detail yang pas
        $routingDetail = RoutingDetail::find()
            ->innerJoin('master_routing', 'master_routing.routing_id = routing_detail.routing_id')
            ->where([
                'master_routing.produk_id' => $wo->id_produk,
                'routing_detail.workcenter_id' => $header->id_workcenter
            ])
            ->one();

        if ($routingDetail) {
            $model->id_routing_detail = $routingDetail->routing_detail_id;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/production-log/view', 'id_log' => $id_log]);
        }

        return $this->renderAjax('create', [
            'model' => $model,
            'routingDetail' => $routingDetail, // Kirim ke view jika ingin ditampilkan namanya
        ]);
    }

    /**
     * Updates an existing ProductionLogActivity model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $activity_id Activity ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($activity_id)
    {
        $model = $this->findModel($activity_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'activity_id' => $model->activity_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ProductionLogActivity model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $activity_id Activity ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($activity_id)
    {
        $this->findModel($activity_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProductionLogActivity model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $activity_id Activity ID
     * @return ProductionLogActivity the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($activity_id)
    {
        if (($model = ProductionLogActivity::findOne(['activity_id' => $activity_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
