<?php

namespace app\controllers;

use app\models\WorkorderMaterial;
use app\models\WorkorderMaterialSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WorkorderMaterialController implements the CRUD actions for WorkorderMaterial model.
 */
class WorkorderMaterialController extends Controller
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
     * Lists all WorkorderMaterial models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new WorkorderMaterialSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WorkorderMaterial model.
     * @param int $wo_mat_id Wo Mat ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($wo_mat_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($wo_mat_id),
        ]);
    }

    /**
     * Creates a new WorkorderMaterial model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new WorkorderMaterial();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'wo_mat_id' => $model->wo_mat_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing WorkorderMaterial model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $wo_mat_id Wo Mat ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($wo_mat_id)
    {
        $model = $this->findModel($wo_mat_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'wo_mat_id' => $model->wo_mat_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing WorkorderMaterial model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $wo_mat_id Wo Mat ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($wo_mat_id)
    {
        $this->findModel($wo_mat_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the WorkorderMaterial model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $wo_mat_id Wo Mat ID
     * @return WorkorderMaterial the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($wo_mat_id)
    {
        if (($model = WorkorderMaterial::findOne(['wo_mat_id' => $wo_mat_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
