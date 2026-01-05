<?php

namespace app\controllers;

use app\helpers\ModelHelper;
use app\models\TenagaKerja;
use app\models\TenagaKerjaSearch;
use Yii;
use yii\base\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TenagaKerjaController implements the CRUD actions for TenagaKerja model.
 */
class TenagaKerjaController extends Controller
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
     * Lists all TenagaKerja models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TenagaKerjaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TenagaKerja model.
     * @param int $tk_id Tk ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($tk_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($tk_id),
        ]);
    }

    /**
     * Creates a new TenagaKerja model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new TenagaKerja();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                // Set timestamp manual jika tidak menggunakan Behaviors
                $model->dibuat_pada = date('Y-m-d H:i:s');
                $model->diupdate_pada = date('Y-m-d H:i:s');

                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Data tenaga kerja berhasil ditambahkan.');
                    return $this->redirect(['index']); // Sesuaikan primary key
                } else {
                    Yii::$app->session->setFlash('error', 'Gagal menyimpan data. Periksa kembali inputan Anda.');
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    /**
     * Updates an existing TenagaKerja model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $tk_id Tk ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($tk_id)
    {
        $model = $this->findModel($tk_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TenagaKerja model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $tk_id Tk ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($tk_id)
    {
        $this->findModel($tk_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TenagaKerja model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $tk_id Tk ID
     * @return TenagaKerja the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($tk_id)
    {
        if (($model = TenagaKerja::findOne(['tk_id' => $tk_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
