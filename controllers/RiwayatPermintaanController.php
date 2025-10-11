<?php

namespace app\controllers;

use app\models\Forecast;
use app\models\ForecastForm;
use app\models\RiwayatPermintaan;
use app\models\RiwayatPermintaanSearch;
use DateTime;
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
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // Filter berdasarkan barang_id jika ada
        $barangId = Yii::$app->request->get('barang_id');
        $query = RiwayatPermintaan::find()
            ->select(['barang_id', 'tahun', 'bulan', 'jumlah_permintaan'])
            ->orderBy(['tahun' => SORT_ASC, 'bulan' => SORT_ASC]);

        if ($barangId) {
            $query->andWhere(['barang_id' => $barangId]);
        }

        $rows = $query->asArray()->all();

        $labels = [];
        $values = [];

        foreach ($rows as $r) {
            $labels[] = $r['tahun'] . '-' . str_pad($r['bulan'], 2, '0', STR_PAD_LEFT);
            $values[] = (int) $r['jumlah_permintaan'];
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'labels' => json_encode($labels),
            'values' => json_encode($values),
            'barangId' => $barangId,
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
        $model = new RiwayatPermintaan();

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
                    $riwayat = new RiwayatPermintaan();
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

    public function actionForecastForm()
    {
        $model = new ForecastForm();
        return $this->renderAjax('_forecast_form', [
            'model' => $model,
        ]);
    }

    public function actionForecastProcess()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model = new ForecastForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $barangIds = (array) $model->barang_id;
            $periode = (int) $model->periode;
            $horizon = (int) $model->horizon;
            $transaction = Yii::$app->db->beginTransaction();
            try {
                foreach ($barangIds as $barangId) {
                    $riwayats = RiwayatPermintaan::find()
                        ->select(['barang_id', 'tahun', 'bulan', 'jumlah_permintaan'])
                        ->where(['barang_id' => $barangId])
                        ->orderBy(['tahun' => SORT_ASC, 'bulan' => SORT_ASC])
                        ->asArray()
                        ->all();

                    if (empty($riwayats)) {
                        return ['success' => false, 'message' => 'Data riwayat permintaan untuk barang ini tidak ditemukan.'];
                    }

                    $values = array_column($riwayats, 'jumlah_permintaan');
                    $window = $periode;

                    $last = end($riwayats);
                    $dt = DateTime::createFromFormat('Y-n', $last['tahun'] . '-' . $last['bulan']);


                    // Loop prediksi 3 bulan ke depan (atau bisa ubah sesuai kebutuhan)
                    for ($i = 0; $i < $horizon; $i++) {
                        $slice = array_slice($values, max(0, count($values) - $window));
                        $avg = $slice ? array_sum($slice) / count($slice) : 0;
                        $prediksi = round($avg);

                        $dt->modify('+1 month');
                        $bulan = (int)$dt->format('n');
                        $tahun = (int)$dt->format('Y');

                        $forecast = new Forecast();
                        $forecast->barang_id = $barangId;
                        $forecast->bulan = $bulan;
                        $forecast->tahun = $tahun;
                        $forecast->metode = 'Single Moving Average';
                        $forecast->hasil_forecast = $prediksi;
                        $forecast->save(false);

                        $values[] = $prediksi; // tambahkan nilai prediksi
                    }
                }
                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Forecast berhasil diproses dan disimpan.');
                return $this->redirect(['forecast/index']);
            } catch (\Throwable $e) {
                $transaction->rollBack();
                return ['success' => false, 'message' => 'Kesalahan: ' . $e->getMessage()];
            }
        }
        return [

            'success' => false,
            'message' => 'Input tidak valid.'
        ];
    }
}
