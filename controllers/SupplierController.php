<?php

namespace app\controllers;

use app\models\Supplier;
use app\models\SupplierSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SupplierController implements the CRUD actions for Supplier model.
 */
class SupplierController extends Controller
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
     * Lists all Supplier models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SupplierSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Supplier model.
     * @param int $supplier_id Supplier ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($supplier_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($supplier_id),
        ]);
    }

    /**
     * Creates a new Supplier model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Supplier();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'supplier_id' => $model->supplier_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Supplier model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $supplier_id Supplier ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($supplier_id)
    {
        $model = $this->findModel($supplier_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'supplier_id' => $model->supplier_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Supplier model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $supplier_id Supplier ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($supplier_id)
    {
        $this->findModel($supplier_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Supplier model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $supplier_id Supplier ID
     * @return Supplier the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($supplier_id)
    {
        if (($model = Supplier::findOne(['supplier_id' => $supplier_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
