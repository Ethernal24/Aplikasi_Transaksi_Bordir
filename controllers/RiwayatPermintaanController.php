<?php

namespace app\controllers;

use app\models\RiwayatPermintaan;
use app\models\RiwayatPermintaanSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RiwayatPermintaanController implements the CRUD actions for RiwayatPermintaan model.
 */
class RiwayatPermintaanController extends Controller
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
     * Lists all RiwayatPermintaan models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new RiwayatPermintaanSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RiwayatPermintaan model.
     * @param int $riwayat_id Riwayat ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($riwayat_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($riwayat_id),
        ]);
    }

    /**
     * Creates a new RiwayatPermintaan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new \app\models\RiwayatPermintaan();

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

            $barangIds = $post['barang_id'] ?? [];
            $bulans = $post['bulan'] ?? [];
            $tahuns = $post['tahun'] ?? [];
            $jumlahs = $post['jumlah'] ?? [];

            $transaction = Yii::$app->db->beginTransaction();
            try {
                foreach ($barangIds as $i => $barangId) {
                    if (empty($barangId) || empty($bulans[$i]) || empty($tahuns[$i]) || empty($jumlahs[$i])) {
                        continue;
                    }

                    // setiap baris input = instance baru dari RiwayatPermintaan
                    $riwayat = new \app\models\RiwayatPermintaan();
                    $riwayat->barang_id = $barangId;
                    $riwayat->bulan = $bulans[$i];
                    $riwayat->tahun = $tahuns[$i];
                    $riwayat->jumlah_permintaan = $jumlahs[$i];

                    if (! $riwayat->save(false)) {
                        throw new \Exception('Gagal menyimpan data riwayat permintaan.');
                    }
                }

                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Data riwayat permintaan berhasil disimpan.');
                return $this->redirect(['index']);
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
        }

        return $this->render('create', [
            'model' => $model, // hanya untuk form
        ]);
    }

    /**
     * Updates an existing RiwayatPermintaan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $riwayat_id Riwayat ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($riwayat_id)
    {
        $model = $this->findModel($riwayat_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'riwayat_id' => $model->riwayat_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing RiwayatPermintaan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $riwayat_id Riwayat ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($riwayat_id)
    {
        $this->findModel($riwayat_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the RiwayatPermintaan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $riwayat_id Riwayat ID
     * @return RiwayatPermintaan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($riwayat_id)
    {
        if (($model = RiwayatPermintaan::findOne(['riwayat_id' => $riwayat_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
