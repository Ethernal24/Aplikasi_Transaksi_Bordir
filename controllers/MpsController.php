<?php

namespace app\controllers;

use app\models\Mps;
use app\models\MpsSearch;
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
        return $this->render('view', [
            'model' => $this->findModel($mps_id),
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

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
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
