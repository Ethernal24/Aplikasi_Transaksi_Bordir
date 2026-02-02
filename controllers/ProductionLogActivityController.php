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
        $wo = $header->wo;

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

        if ($model->load(Yii::$app->request->post())) {
            // --- LOGIKA PERHITUNGAN DURASI ---

            // 1. Catat waktu input saat ini
            $now = date('Y-m-d H:i:s');
            $model->created_at = $now;

            // 2. Cari aktivitas sebelumnya pada header yang sama
            $previousActivity = ProductionLogActivity::find()
                ->where(['id_log' => $id_log])
                ->orderBy(['id_activity' => SORT_DESC]) // Pastikan nama primary key sesuai (id_activity atau id)
                ->one();

            if ($previousActivity) {
                // Jika sudah ada input sebelumnya, start diambil dari input terakhir
                $startTime = strtotime($previousActivity->created_at);
            } else {
                // Jika ini input pertama, start diambil dari waktu mulai Header
                // Pastikan di tabel ProductionLog ada kolom start_at
                $startTime = strtotime($header->start_at);
            }

            // 3. Hitung selisih dalam menit
            $endTime = strtotime($now);
            $diffInSeconds = $endTime - $startTime;

            // Simpan ke kolom duration (pastikan kolom ini ada di tabel)
            $model->durasi_menit = ($diffInSeconds > 0) ? round($diffInSeconds / 60, 2) : 0;

            if ($model->save()) {
                return $this->redirect(['/production-log/view', 'id_log' => $id_log]);
            }
        }

        $totalSelesai = $model->find()
            ->joinWith('log')
            ->where(['production_log.id_wo' => $wo->id_wo])
            ->sum('qty_output_total') ?? 0;

        $sisaReal = $wo->qty_target - $totalSelesai;

        return $this->renderAjax('create', [
            'model' => $model,
            'routingDetail' => $routingDetail,
            'sisaReal' => $sisaReal,
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
