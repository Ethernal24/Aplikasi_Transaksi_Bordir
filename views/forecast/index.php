<?php

use app\models\Forecast;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ForecastSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Forecasts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pc-content">
    <div class="card table-card">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
            <?= Html::a('Riwayat Permintaan', ['riwayat-permintaan/index'], ['class' => 'btn btn-info']) ?>
        </div>
        <div class="card-body mx-4">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    // 'forecast_id',
                    [
                        'attribute' => 'barang_id',
                        'value' => 'barang.nama_barang',
                        'label' => 'Nama Produk',
                        'filterInputOptions' => [
                            'class' => 'form-control',
                            'placeholder' => 'Cari Nama Produk',
                        ]

                    ],
                    [
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
                    ],
                    'tahun',
                    'metode',
                    'hasil_forecast',
                    'order_aktual',
                    'mse',
                ],
            ]); ?>
        </div>
    </div>
</div>