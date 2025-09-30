<?php

namespace app\controllers;

use app\models\PermintaanPelanggan;
use app\models\PermintaanPelangganSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PermintaanPelangganController implements the CRUD actions for PermintaanPelanggan model.
 */
class PermintaanPelangganController extends Controller
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
     * Lists all PermintaanPelanggan models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PermintaanPelangganSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PermintaanPelanggan model.
     * @param int $permintaan_id Permintaan ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($permintaan_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($permintaan_id),
        ]);
    }

    /**
     * Creates a new PermintaanPelanggan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new PermintaanPelanggan();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'permintaan_id' => $model->permintaan_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PermintaanPelanggan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $permintaan_id Permintaan ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($permintaan_id)
    {
        $model = $this->findModel($permintaan_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'permintaan_id' => $model->permintaan_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PermintaanPelanggan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $permintaan_id Permintaan ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($permintaan_id)
    {
        $this->findModel($permintaan_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PermintaanPelanggan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $permintaan_id Permintaan ID
     * @return PermintaanPelanggan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($permintaan_id)
    {
        if (($model = PermintaanPelanggan::findOne(['permintaan_id' => $permintaan_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
