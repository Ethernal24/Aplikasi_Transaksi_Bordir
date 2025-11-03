<?php

namespace app\controllers;

use app\models\Barang;
use app\models\Forecast;
use app\models\ForecastForm;
use app\models\Mps;
use app\models\MpsDetail;
use app\models\RiwayatPermintaan;
use app\models\RiwayatPermintaanSearch;
use DateTime;
use Yii;
use yii\db\Expression;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Carbon\Carbon;

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

                    $forecast = Forecast::find()
                        ->where([
                            'barang_id' => $barangId,
                            'bulan' => $bulans[$i],
                            'tahun' => $tahuns[$i],
                        ])
                        ->one();
                    if ($forecast) {
                        $forecast->order_aktual = $jumlahs[$i];
                        if ($forecast->hasil_forecast !== null) {
                            $forecast->mse = pow($forecast->hasil_forecast - $forecast->order_aktual, 2);
                        }

                        if (! $forecast->save(false)) {
                            throw new \Exception('Gagal memperbarui data forecasting.');
                        }
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
            $window = 3; // ambil 3 bulan terakhir

            $transaction = Yii::$app->db->beginTransaction();

            try {
                foreach ($barangIds as $barangId) {
                    // Ambil 3 bulan terakhir dari riwayat permintaan
                    $riwayats = RiwayatPermintaan::find()
                        ->select(['barang_id', 'tahun', 'bulan', 'jumlah_permintaan'])
                        ->where(['barang_id' => $barangId])
                        ->orderBy(['tahun' => SORT_DESC, 'bulan' => SORT_DESC])
                        ->limit($window)
                        ->asArray()
                        ->all();

                    if (empty($riwayats) || count($riwayats) < $window) {
                        return [
                            'success' => false,
                            'message' => 'Data riwayat permintaan kurang dari 3 bulan untuk melakukan forecast.'
                        ];
                    }

                    // Urutkan ulang ascending agar urutan bulan benar
                    $riwayats = array_reverse($riwayats);
                    $values = array_column($riwayats, 'jumlah_permintaan');

                    // Hitung rata-rata (Single Moving Average)
                    $avg = array_sum($values) / count($values);
                    $prediksi = round($avg);

                    // Tentukan bulan & tahun berikutnya
                    $last = end($riwayats);
                    $dt = DateTime::createFromFormat('Y-n', $last['tahun'] . '-' . $last['bulan']);
                    $dt->modify('+1 month');
                    $bulan = (int)$dt->format('n');
                    $tahun = (int)$dt->format('Y');

                    // Cek Forecast
                    $cekForecast = Forecast::find()
                        ->where([
                            'barang_id' => $barangId,
                            'bulan' => $bulan,
                            'tahun' => $tahun
                        ])
                        ->exists();
                    if ($cekForecast) {
                        continue;
                    }


                    // Simpan hasil forecast
                    $forecast = new Forecast();
                    $forecast->barang_id = $barangId;
                    $forecast->bulan = $bulan;
                    $forecast->tahun = $tahun;
                    $forecast->metode = 'Single Moving Average';
                    $forecast->hasil_forecast = (float) $prediksi;
                    $forecast->order_aktual = 0;
                    $forecast->mse = 0;
                    $forecast->save(false);
                    $stockAwal = 0;
                    $rencanaproduksi = $prediksi - $stockAwal;
                    if ($rencanaproduksi < 0) {
                        $rencanaproduksi = 0;
                    }
                    $this->createMps($barangId, $bulan, $tahun, $rencanaproduksi, 0, 0);
                }
                $transaction->commit();

                return [
                    'success' => true,
                    'message' => 'Forecast berhasil diproses dan disimpan.',
                    'data' => [
                        'barang_id' => $barangId,
                        'bulan' => $bulan,
                        'tahun' => $tahun,
                        'hasil_forecast' => $prediksi
                    ]
                ];
            } catch (\Throwable $e) {
                $transaction->rollBack();
                return [
                    'success' => false,
                    'message' => 'Kesalahan: ' . $e->getMessage()
                ];
            }
        }
    }

    public function createMps($barang_id, $bulan, $tahun, $rencanaproduksi, $tipe, $sumber)
    {
        $cekMps = Mps::find()
            ->where([
                'barang_id' => $barang_id,
            ])
            ->andWhere(['between', 'periode', "$tahun-$bulan-01", "$tahun-$bulan-31"])
            ->exists();

        if ($cekMps) {
            return false;
        }

        $mps = new Mps();
        $periodeBulan = str_pad($bulan, 2, '0', STR_PAD_LEFT);
        $tanggalForecast = strtotime("$tahun-$periodeBulan-01");
        $periode = date('Y-m-01', $tanggalForecast);
        $dateline = date('Y-m-t', $tanggalForecast);


        $mps->periode = $periode;
        $mps->tanggal_awal = $periode;
        $mps->dateline = $dateline;
        $mps->barang_id = $barang_id;
        $mps->qty = $rencanaproduksi;
        $mps->tipe = $tipe;
        $mps->sumber = $sumber;
        $mps->status_mps = 0;
        $mps->dibuat_pada = date('Y-m-d H:i:s');
        $mps->diupdate_pada = date('Y-m-d H:i:s');
        $mps->save(false);
        $this->createMpsDetail($mps);
    }
    public function createMpsDetail($mps)
    {
        $forecastBulanan = $mps->qty ?? 0;
        $forecastMingguan = $forecastBulanan / 4;

        $barang = $mps->barang;
        $stokAwal = $barang ? $barang->stok : 0;
        $pabSebelumnya = $stokAwal;

        for ($i = 1; $i <= 4; $i++) {
            $detail = new MpsDetail();
            $detail->mps_id = $mps->mps_id;
            $detail->minggu_ke = $i;
            $detail->forecast = $forecastMingguan;
            $detail->order_aktual = 0;
            $rencana_produksi = max($detail->forecast, $detail->order_aktual) + max($detail->forecast, $detail->order_aktual) / 2;
            $detail->stok = $pabSebelumnya + $rencana_produksi - max($detail->forecast, $detail->order_aktual);
            $detail->rencana_produksi = $rencana_produksi;
            if ($i === 1) {
                $detail->stok = $stokAwal;
            } else {
                $detail->stok = $pabSebelumnya + $rencana_produksi - max($detail->forecast, $detail->order_aktual);
            }
            $pabSebelumnya = $detail->stok;

            if (!$detail->save(false)) {
                Yii::info('Gagal simpan MPS Detail minggu ke ' . $i . ' untuk MPS ' . $mps->mps_id, __METHOD__);
            }
        }
    }
}
