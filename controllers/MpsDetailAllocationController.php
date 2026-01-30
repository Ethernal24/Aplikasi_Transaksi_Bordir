<?php

namespace app\controllers;

use app\models\MpsDetailAllocation;
use app\models\MpsDetailAllocationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MpsDetailAllocationController implements the CRUD actions for MpsDetailAllocation model.
 */
class MpsDetailAllocationController extends Controller
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
     * Lists all MpsDetailAllocation models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MpsDetailAllocationSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MpsDetailAllocation model.
     * @param int $mps_detail_allocation_id Mps Detail Allocation ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($mps_detail_allocation_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($mps_detail_allocation_id),
        ]);
    }

    /**
     * Creates a new MpsDetailAllocation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new MpsDetailAllocation();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'mps_detail_allocation_id' => $model->mps_detail_allocation_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MpsDetailAllocation model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $mps_detail_allocation_id Mps Detail Allocation ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($mps_detail_allocation_id)
    {
        $model = $this->findModel($mps_detail_allocation_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'mps_detail_allocation_id' => $model->mps_detail_allocation_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MpsDetailAllocation model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $mps_detail_allocation_id Mps Detail Allocation ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($mps_detail_allocation_id)
    {
        $this->findModel($mps_detail_allocation_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MpsDetailAllocation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $mps_detail_allocation_id Mps Detail Allocation ID
     * @return MpsDetailAllocation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($mps_detail_allocation_id)
    {
        if (($model = MpsDetailAllocation::findOne(['mps_detail_allocation_id' => $mps_detail_allocation_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
