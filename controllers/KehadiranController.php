<?php

namespace app\controllers;

use app\models\Kehadiran;
use app\models\KehadiranSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * KehadiranController implements the CRUD actions for Kehadiran model.
 */
class KehadiranController extends Controller
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
     * Lists all Kehadiran models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new KehadiranSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Kehadiran model.
     * @param int $kehadiran_id Kehadiran ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($kehadiran_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($kehadiran_id),
        ]);
    }

    /**
     * Creates a new Kehadiran model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Kehadiran();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', "Kehadiran berhasil dicatat.");
                return $this->redirect(['index', 'kehadiran_id' => $model->kehadiran_id]);
            } else {
                Yii::$app->session->setFlash('error', "Gagal simpan! Anda mungkin sudah input di tanggal ini.");
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Kehadiran model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $kehadiran_id Kehadiran ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($kehadiran_id)
    {
        $model = $this->findModel($kehadiran_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'kehadiran_id' => $model->kehadiran_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Kehadiran model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $kehadiran_id Kehadiran ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($kehadiran_id)
    {
        $this->findModel($kehadiran_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Kehadiran model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $kehadiran_id Kehadiran ID
     * @return Kehadiran the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($kehadiran_id)
    {
        if (($model = Kehadiran::findOne(['kehadiran_id' => $kehadiran_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
