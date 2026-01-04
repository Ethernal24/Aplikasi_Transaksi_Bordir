<?php

use app\models\ProductionLog;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ProductionLogSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Log Produksi';
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
                    [
                        'attribute' => 'tanggal',
                        'label' => 'Tanggal Kerja',
                        'format' => ['date', 'php: d-M-y'],
                    ],
                    [
                        'attribute' => 'kode_log',
                        'label' => 'Kode Log',
                        'value' => 'kode_log',
                    ],
                    [
                        'attribute' => 'id_wo',
                        'label' => 'Kode WO',
                        'value' => 'wo.kode_wo',
                    ],
                    [
                        'attribute' => 'id_workcenter',
                        'label' => 'Workcenter',
                        'value' => 'workcenter.nama_workcenter',
                    ],
                    [
                        'attribute' => 'id_shift',
                        'label' => 'Shift',
                        'value' => 'shift.nama_shift',
                    ],
                    [
                        'attribute' => 'status',
                        'label' => 'Status',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $label = $model->labelStatus;
                            return "<span class= '{$label['class']}'>{$label['label']}</span>";
                        },
                    ],

                    [
                        'class' => ActionColumn::className(),
                        'urlCreator' => function ($action, ProductionLog $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'id_log' => $model->id_log]);
                        }
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>