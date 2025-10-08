<?php

namespace app\controllers;

use app\models\Forecast;
use app\models\ForecastSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ForecastController implements the CRUD actions for Forecast model.
 */
class ForecastController extends Controller
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
     * Lists all Forecast models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ForecastSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Forecast model.
     * @param int $forecast_id Forecast ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($forecast_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($forecast_id),
        ]);
    }

    /**
     * Creates a new Forecast model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Forecast();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'forecast_id' => $model->forecast_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Forecast model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $forecast_id Forecast ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($forecast_id)
    {
        $model = $this->findModel($forecast_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'forecast_id' => $model->forecast_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Forecast model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $forecast_id Forecast ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($forecast_id)
    {
        $this->findModel($forecast_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Forecast model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $forecast_id Forecast ID
     * @return Forecast the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($forecast_id)
    {
        if (($model = Forecast::findOne(['forecast_id' => $forecast_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
