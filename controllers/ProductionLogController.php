<?php

namespace app\controllers;

use app\models\ProductionLog;
use app\models\ProductionLogActivity;
use app\models\ProductionLogAttendance;
use app\models\ProductionLogDetail;
use app\models\ProductionLogDowntime;
use app\models\ProductionLogSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductionLogController implements the CRUD actions for ProductionLog model.
 */
class ProductionLogController extends Controller
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
     * Lists all ProductionLog models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProductionLogSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductionLog model.
     * @param int $production_log_id Production Log ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_log)
    {
        $model = $this->findModel($id_log);
        $activityProvider = new ActiveDataProvider([
            'query' => ProductionLogActivity::find()->where(['id_log' => $id_log]),
            'pagination' => [
                'pageSize' => 10, // Menampilkan 10 data per halaman di dalam tab
            ],
            'sort' => [
                'defaultOrder' => ['id_activity' => SORT_DESC], // Data terbaru di atas
            ],
        ]);

        // 2. Jika Anda sudah buat tabel Detail, siapkan juga provider-nya
        $detailProvider = new ActiveDataProvider([
            'query' => ProductionLogDetail::find()->where(['log_id' => $id_log]),
        ]);

        $attendanceProvider = new ActiveDataProvider([
            'query' => ProductionLogAttendance::find()->where(['log_id' => $id_log]),
        ]);
        $downtimeProvider = new ActiveDataProvider([
            'query' => ProductionLogDowntime::find()->where(['log_id' => $id_log]),
        ]);


        return $this->render('view', [
            'model' => $model,
            'activityProvider' => $activityProvider, // Kirim ke view
            'detailProvider' => $detailProvider,
            'attendanceProvider' => $attendanceProvider,
            'downtimeProvider' => $downtimeProvider,
        ]);
    }

    /**
     * Creates a new ProductionLog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new ProductionLog();

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
     * Updates an existing ProductionLog model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $production_log_id Production Log ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($production_log_id)
    {
        $model = $this->findModel($production_log_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'production_log_id' => $model->production_log_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ProductionLog model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $production_log_id Production Log ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($production_log_id)
    {
        $this->findModel($production_log_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProductionLog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $production_log_id Production Log ID
     * @return ProductionLog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_log)
    {
        if (($model = ProductionLog::findOne(['id_log' => $id_log])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
