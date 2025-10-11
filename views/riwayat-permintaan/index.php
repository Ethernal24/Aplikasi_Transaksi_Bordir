<?php

use app\models\Barang;
use app\models\RiwayatPermintaan;
use kartik\widgets\Select2;
use kartik\widgets\Typeahead;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use dosamigos\chartjs\ChartJs;
use yii\bootstrap5\Modal;
use yii\widgets\Pjax;

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
            <!-- <?= Html::a('Generate Forecast', ['generate-forecast'], [
                        'class' => 'btn btn-info',
                        'data' => [
                            'confirm' => 'Apakah ingin generate data forecast?',
                            'method' => 'post',
                        ]
                    ]) ?> -->

            <!-- Modal Forecasting -->
            <?= Html::a('Generate Forecast', ['riwayat-permintaan/forecast-form'], [
                'class' => 'btn btn-info btn-modal',
            ]); ?>

            <?php
            Modal::begin([
                'id' => 'ajaxModal',
                'title' => 'Pengaturan Forecast',
            ]);
            echo '<div id="modalContent"></div>';
            Modal::end();
            ?>
        </div>
        <div class="card-body mx-4">
            <?php Pjax::begin(); ?>
            <div class="table-responsive">
                <div>
                    <?php
                    // ambil data yang difilter dari dataProvider
                    $dataQuery = clone $dataProvider->query;
                    $data = $dataQuery
                        ->select([
                            'bulan' => 'bulan',
                            'tahun' => 'tahun',
                            'jumlah_permintaan' => 'SUM(jumlah_permintaan)',
                        ])
                        ->groupBy(['bulan', 'tahun'])
                        ->orderBy(['tahun' => SORT_ASC, 'bulan' => SORT_ASC])
                        ->asArray()
                        ->all();

                    $labels = array_map(function ($d) {
                        $bulanNama = [
                            1 => 'Jan',
                            2 => 'Feb',
                            3 => 'Mar',
                            4 => 'Apr',
                            5 => 'Mei',
                            6 => 'Jun',
                            7 => 'Jul',
                            8 => 'Agu',
                            9 => 'Sep',
                            10 => 'Okt',
                            11 => 'Nov',
                            12 => 'Des'
                        ];
                        return $bulanNama[$d['bulan']] . ' ' . $d['tahun'];
                    }, $data);
                    $values = array_map(fn($d) => (int) $d['jumlah_permintaan'], $data);
                    ?>

                    <?= ChartJs::widget([
                        'type' => 'line',
                        'options' => [
                            'width' => 500,
                            'height' => 150,
                        ],
                        'data' => [
                            'labels' => $labels,
                            'datasets' => [
                                [
                                    'label' => 'Jumlah Permintaan',
                                    'data' => $values,
                                    'backgroundColor' => 'rgba(54, 162, 235, 0.5)',
                                    'borderColor' => 'rgba(54, 162, 235, 1)',
                                    'borderWidth' => 1,
                                ],
                            ],
                        ],
                    ]) ?>
                </div>
                <hr>
                <div>

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
                                'filter' => Select2::widget([
                                    'model' => $searchModel,
                                    'attribute' => 'nama_barang',
                                    'data' => ArrayHelper::map(
                                        Barang::find()
                                            ->select('nama_barang')
                                            ->where(['tipe_barang' => 2])
                                            ->distinct()
                                            ->orderBy(['nama_barang' => SORT_ASC])
                                            ->asArray()
                                            ->all(),
                                        'nama_barang',
                                        'nama_barang'
                                    ),
                                    'options' => [
                                        'placeholder' => 'pilih Produk',
                                        'class' => 'form-control',
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                    ]
                                ]),
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
                                },
                                'filter' => Select2::widget([
                                    'model' => $searchModel,
                                    'attribute' => 'bulan',
                                    'data' => ArrayHelper::map(
                                        RiwayatPermintaan::find()
                                            ->select('bulan')
                                            ->distinct()
                                            ->orderBy(['bulan' => SORT_ASC])
                                            ->asArray()
                                            ->all(),
                                        'bulan',
                                        'bulan'
                                    ),
                                    'options' => [
                                        'placeholder' => 'pilih bulan',
                                        'class' => 'form-control',
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                    ]
                                ])
                            ],
                            'tahun' => [
                                'attribute' => 'tahun',
                                'value' => 'tahun',
                                'filter' => Select2::widget([
                                    'model' => $searchModel,
                                    'attribute' => 'tahun',
                                    'data' => ArrayHelper::map(
                                        RiwayatPermintaan::find()
                                            ->select('tahun')
                                            ->distinct()
                                            ->orderBy(['tahun' => SORT_DESC])
                                            ->asArray()
                                            ->all(),
                                        'tahun',
                                        'tahun'
                                    ),
                                    'options' => [
                                        'placeholder' => 'pilih tahun',
                                        'class' => 'form-control',
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                    ]
                                ])
                            ],
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
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>

<?php
$script = <<<JS
    $('.btn-modal').on('click', function(e) {
    e.preventDefault();
    $('#ajaxModal').modal('show')
    .find('#modalContent')
    .load($(this).attr('href'));
    });
    JS;
$this->registerJs($script);
?>