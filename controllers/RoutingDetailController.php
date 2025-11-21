<?php

namespace app\controllers;

use app\models\RoutingDetail;
use app\models\RoutingDetailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RoutingDetailController implements the CRUD actions for RoutingDetail model.
 */
class RoutingDetailController extends Controller
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
     * Lists all RoutingDetail models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new RoutingDetailSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RoutingDetail model.
     * @param int $routing_detail_id Routing Detail ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($routing_detail_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($routing_detail_id),
        ]);
    }

    /**
     * Creates a new RoutingDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new RoutingDetail();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'routing_detail_id' => $model->routing_detail_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing RoutingDetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $routing_detail_id Routing Detail ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($routing_detail_id)
    {
        $model = $this->findModel($routing_detail_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'routing_detail_id' => $model->routing_detail_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing RoutingDetail model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $routing_detail_id Routing Detail ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($routing_detail_id)
    {
        $this->findModel($routing_detail_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the RoutingDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $routing_detail_id Routing Detail ID
     * @return RoutingDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($routing_detail_id)
    {
        if (($model = RoutingDetail::findOne(['routing_detail_id' => $routing_detail_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
