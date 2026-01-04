<?php

namespace app\controllers;

use app\models\ProductionLogDowntime;
use app\models\ProductionLogDowntimeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductionLogDowntimeController implements the CRUD actions for ProductionLogDowntime model.
 */
class ProductionLogDowntimeController extends Controller
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
     * Lists all ProductionLogDowntime models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProductionLogDowntimeSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductionLogDowntime model.
     * @param int $downtime_id Downtime ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($downtime_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($downtime_id),
        ]);
    }

    /**
     * Creates a new ProductionLogDowntime model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new ProductionLogDowntime();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'downtime_id' => $model->downtime_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ProductionLogDowntime model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $downtime_id Downtime ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($downtime_id)
    {
        $model = $this->findModel($downtime_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'downtime_id' => $model->downtime_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ProductionLogDowntime model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $downtime_id Downtime ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($downtime_id)
    {
        $this->findModel($downtime_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProductionLogDowntime model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $downtime_id Downtime ID
     * @return ProductionLogDowntime the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($downtime_id)
    {
        if (($model = ProductionLogDowntime::findOne(['downtime_id' => $downtime_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
