<?php

use app\models\RiwayatPermintaan;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\RiwayatPermintaanSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Riwayat Permintaan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pc-content">
    <div class="card table-card">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>

            <?= Html::a('Create Riwayat Permintaan', ['create'], ['class' => 'btn btn-success']) ?>
            <?= Html::a('Forecast', ['forecast/index'], ['class' => 'btn btn-info']) ?>
            <?= Html::a('Generate Forecast', ['generate-forecast'], [
                'class' => 'btn btn-info',
                'data' => [
                    'confirm' => 'Apakah ingin generate data forecast?',
                    'method' => 'post',
                ]
            ]) ?>

            <!-- Dropdown Filter Barang -->
            <div class="my-3">
                <label for="barangFilter"><b>Filter berdasarkan Barang:</b></label>
                <?= Html::dropDownList(
                    'barang_id',
                    $barangId,
                    \yii\helpers\ArrayHelper::map(
                        \app\models\Barang::find()->where(['tipe_barang' => 2])->all(),
                        'barang_id',
                        'nama_barang'
                    ),
                    [
                        'prompt' => 'Semua Barang',
                        'id' => 'barangFilter',
                        'class' => 'form-control',
                        'style' => 'max-width:300px; display:inline-block; margin-left:10px;'
                    ]
                ) ?>
            </div>

            <!-- Grafik -->
            <div class="border border-dark p-3 m-4 rounded drop-shado">
                <?= $this->render('view-grafik', [
                    'labels' => $labels,
                    'values' => $values,
                ]) ?>
            </div>
        </div>
        <div class="card-body mx-4">
            <div class="table-responsive">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        // 'riwayat_id',
                        [
                            'attribute' => 'nama_barang',
                            'value' => 'barang.nama_barang',
                            'label' => 'Nama Produk',

                        ],
                        'bulan' => [
                            'attribute' => 'bulan',
                            'value' => function ($model) {
                                $list = [
                                    '1' => 'Januari',
                                    '2' => 'Februari',
                                    '3' => 'Maret',
                                    '4' => 'April',
                                    '5' => 'Mei',
                                    '6' => 'Juni',
                                    '7' => 'Juli',
                                    '8' => 'Agustus',
                                    '9' => 'September',
                                    '10' => 'Oktober',
                                    '11' => 'November',
                                    '12' => 'Desember',
                                ];
                                return $list[$model->bulan] ?? null;
                            }
                        ],
                        'tahun',
                        'jumlah_permintaan',
                        [
                            'class' => ActionColumn::className(),
                            'urlCreator' => function ($action, RiwayatPermintaan $model, $key, $index, $column) {
                                return Url::toRoute([$action, 'riwayat_id' => $model->riwayat_id]);
                            }
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
<canvas id="permintaanChart" height="100"></canvas>

<?php
$chartUrl = \yii\helpers\Url::to(['chart-data']);
$script = <<<JS
let chartCtx = document.getElementById('permintaanChart').getContext('2d');
let permintaanChart;

function updateChart(filters = {}) {
    $.get('$chartUrl', filters, function(data) {
        let labels = data.map(item => item.nama_barang);
        let values = data.map(item => item.total);

        if (permintaanChart) permintaanChart.destroy();
        permintaanChart = new Chart(chartCtx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Permintaan',
                    data: values
                }]
            }
        });
    });
}

// pertama kali load
updateChart();

// kalau mau sinkron dengan filter GridView, tangkap event submit form filter
$('#w0').on('beforeSubmit', function(e) {
    let filters = $(this).serializeArray().reduce((acc, cur) => (acc[cur.name] = cur.value, acc), {});
    updateChart(filters);
    return false; // biar tidak reload
});
JS;
$this->registerJs($script);
?>