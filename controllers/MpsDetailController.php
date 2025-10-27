<?php

namespace app\controllers;

use app\models\MpsDetail;
use app\models\MpsDetailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MpsDetailController implements the CRUD actions for MpsDetail model.
 */
class MpsDetailController extends Controller
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
     * Lists all MpsDetail models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MpsDetailSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MpsDetail model.
     * @param int $mps_detail_id Mps Detail ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($mps_detail_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($mps_detail_id),
        ]);
    }

    /**
     * Creates a new MpsDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new MpsDetail();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'mps_detail_id' => $model->mps_detail_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MpsDetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $mps_detail_id Mps Detail ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($mps_detail_id)
    {
        $model = $this->findModel($mps_detail_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'mps_detail_id' => $model->mps_detail_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MpsDetail model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $mps_detail_id Mps Detail ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($mps_detail_id)
    {
        $this->findModel($mps_detail_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MpsDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $mps_detail_id Mps Detail ID
     * @return MpsDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($mps_detail_id)
    {
        if (($model = MpsDetail::findOne(['mps_detail_id' => $mps_detail_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
