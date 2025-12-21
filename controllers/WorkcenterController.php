<?php

namespace app\controllers;

use app\models\Workcenter;
use app\models\WorkcenterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WorkcenterController implements the CRUD actions for Workcenter model.
 */
class WorkcenterController extends Controller
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
     * Lists all Workcenter models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new WorkcenterSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Workcenter model.
     * @param int $workcenter_id Workcenter ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($workcenter_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($workcenter_id),
        ]);
    }

    /**
     * Creates a new Workcenter model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Workcenter();

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
     * Updates an existing Workcenter model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $workcenter_id Workcenter ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($workcenter_id)
    {
        $model = $this->findModel($workcenter_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Workcenter model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $workcenter_id Workcenter ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($workcenter_id)
    {
        $this->findModel($workcenter_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Workcenter model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $workcenter_id Workcenter ID
     * @return Workcenter the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($workcenter_id)
    {
        if (($model = Workcenter::findOne(['workcenter_id' => $workcenter_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
