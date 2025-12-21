<?php

namespace app\controllers;

use app\models\ProductionLog;
use app\models\ProductionLogSearch;
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
    public function actionView($production_log_id)
    {
        $model = $this->findModel($production_log_id);
        $detail = $model->detail;
        $activity = $model->activity;
        return $this->render('view', [
            'model' => $model,
            'detail' => $detail,
            'activity' => $activity,
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
    protected function findModel($production_log_id)
    {
        if (($model = ProductionLog::findOne(['production_log_id' => $production_log_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
