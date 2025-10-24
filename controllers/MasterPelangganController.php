<?php

namespace app\controllers;

use app\models\MasterPelanggan;
use app\models\MasterPelangganSearch;
use app\models\PermintaanDetail;
use app\models\PermintaanPelanggan;
use app\models\ProdukCustomPelanggan;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MasterPelangganController implements the CRUD actions for MasterPelanggan model.
 */
class MasterPelangganController extends Controller
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
     * Lists all MasterPelanggan models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MasterPelangganSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MasterPelanggan model.
     * @param int $pelanggan_id Pelanggan ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($pelanggan_id)
    {
        $model = $this->findModel($pelanggan_id);
        $produk = ProdukCustomPelanggan::find()
            ->where(['pelanggan_id' => $pelanggan_id])
            ->all();
        return $this->render('view', [
            'model' => $model,
            'produk' => $produk,
        ]);
    }

    /**
     * Creates a new MasterPelanggan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new MasterPelanggan();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'pelanggan_id' => $model->pelanggan_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MasterPelanggan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $pelanggan_id Pelanggan ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($pelanggan_id)
    {
        $model = $this->findModel($pelanggan_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'pelanggan_id' => $model->pelanggan_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MasterPelanggan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $pelanggan_id Pelanggan ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($pelanggan_id)
    {
        $this->findModel($pelanggan_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MasterPelanggan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $pelanggan_id Pelanggan ID
     * @return MasterPelanggan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($pelanggan_id)
    {
        if (($model = MasterPelanggan::findOne(['pelanggan_id' => $pelanggan_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionDetailAjax($produk_custom_pelanggan_id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_HTML;

        $produk = ProdukCustomPelanggan::find()
            ->with('bomCustom') // jika kamu punya relasi BOM
            ->where(['produk_custom_pelanggan_id' => $produk_custom_pelanggan_id])
            ->one();

        if (!$produk) {
            return '<div class="text-danger">Data produk tidak ditemukan.</div>';
        }

        try {
            return $this->renderPartial('_view_detail', [
                'produk' => $produk,
                'bomList' => $produk->bomCustom, // pastikan dipassing kalau di view butuh
            ]);
        } catch (\Throwable $e) {
            Yii::error($e->getMessage(), __METHOD__);
            return '<div class="text-danger">Terjadi kesalahan saat memuat detail.</div>';
        }
    }
}
