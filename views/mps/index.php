<?php

use app\models\Mps;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\MpsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Master Production Schedule';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pc-content">
    <div class="card table-card">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
            <?= Html::a('Buat Mps', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="card-body mx-4">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    // 'mps_id',
                    'forecast.barang.nama_barang',
                    'forecast.bulan',
                    'forecast.tahun',
                    'forecast_id' => [
                        'attribute' => 'forecast_id',
                        'value' => 'forecast.hasil_forecast',
                        'label' => 'hasil Forecast',
                    ],
                    'stock_awal',
                    'rencana_produksi',
                    [
                        'class' => ActionColumn::className(),
                        'urlCreator' => function ($action, Mps $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'mps_id' => $model->mps_id]);
                        }
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>