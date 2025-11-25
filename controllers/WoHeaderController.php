<?php

namespace app\controllers;

use app\models\WoDetailMat;
use app\models\WoDetailOpr;
use app\models\WoHeader;
use app\models\WoHeaderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WoHeaderController implements the CRUD actions for WoHeader model.
 */
class WoHeaderController extends Controller
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
     * Lists all WoHeader models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new WoHeaderSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WoHeader model.
     * @param int $wo_id Wo ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($wo_id)
    {
        $detailOpr = WoDetailOpr::find()
            ->where(['wo_id' => $wo_id])
            ->all();
        $detailMat = WoDetailMat::find()
            ->where(['wo_id' => $wo_id])
            ->all();
        $model = $this->findModel($wo_id);
        return $this->render('view', [
            'model' => $model,
            'detailOpr' => $detailOpr,
            'detailMat' => $detailMat,
        ]);
    }

    /**
     * Creates a new WoHeader model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new WoHeader();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'wo_id' => $model->wo_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing WoHeader model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $wo_id Wo ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($wo_id)
    {
        $model = $this->findModel($wo_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'wo_id' => $model->wo_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing WoHeader model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $wo_id Wo ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($wo_id)
    {
        $this->findModel($wo_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the WoHeader model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $wo_id Wo ID
     * @return WoHeader the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($wo_id)
    {
        if (($model = WoHeader::findOne(['wo_id' => $wo_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
