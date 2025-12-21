<?php

use app\models\ProductionLog;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ProductionLogSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Laporan Produksi';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pc-content">
    <div class="card table-card">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
            <?= Html::a('Create Laporan Shift', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="card-body mx-4">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    // 'production_log_id',
                    [
                        'attribute' => 'tanggal',
                        'label' => 'Tanggal Kerja',
                        'format' => ['date', 'php: d-M-y'],
                    ],
                    [
                        'attribute' => 'mesin_id',
                        'label' => 'Nama Mesin',
                        'value' => 'mesin.nama_mesin',
                    ],
                    [
                        'attribute' => 'tk_id',
                        'label' => 'Tenaga Kerja',
                        'value' => 'tenagaKerja.nama',
                    ],
                    [
                        'attribute' => 'shift_id',
                        'value' => 'shift.nama_shift',
                        'label' => 'Shift',
                    ],
                    'waktu_kerja',
                    'mulai_istirahat',
                    'selesai_istirahat',
                    [
                        'class' => ActionColumn::className(),
                        'urlCreator' => function ($action, ProductionLog $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'production_log_id' => $model->production_log_id]);
                        }
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>