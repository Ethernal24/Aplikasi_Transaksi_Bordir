<?php

namespace app\controllers;

use app\models\ProductionLogDetail;
use app\models\ProductionLogDetailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductionLogDetailController implements the CRUD actions for ProductionLogDetail model.
 */
class ProductionLogDetailController extends Controller
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
     * Lists all ProductionLogDetail models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProductionLogDetailSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductionLogDetail model.
     * @param int $detail_id Detail ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($detail_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($detail_id),
        ]);
    }

    /**
     * Creates a new ProductionLogDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new ProductionLogDetail();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'detail_id' => $model->detail_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ProductionLogDetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $detail_id Detail ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($detail_id)
    {
        $model = $this->findModel($detail_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'detail_id' => $model->detail_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ProductionLogDetail model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $detail_id Detail ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($detail_id)
    {
        $this->findModel($detail_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProductionLogDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $detail_id Detail ID
     * @return ProductionLogDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($detail_id)
    {
        if (($model = ProductionLogDetail::findOne(['detail_id' => $detail_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
