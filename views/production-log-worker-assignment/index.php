<?php

use app\models\ProductionLogWorkerAssignment;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ProductionLogWorkerAssignmentSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Jadwal Shift';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pc-content">
    <div class="card table-card">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
            <?= Html::a('Buat Jadwal Shift', ['create'], ['class' => 'btn btn-success']) ?>
            <?= Html::a('Tampilkan Jadwal Shift', ['jadwal-karyawan'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="card-body mx-4">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    // 'id_assignment',
                    [
                        'attribute' => 'tanggal_assignment',
                        'label' => 'Tanggal Kerja',
                        'value' => 'tanggal_assignment',
                    ],
                    [
                        'attribute' => 'id_tk',
                        'label' => 'Tenaga Kerja',
                        'value' => function ($model) {
                            return $model->tk ? $model->tk->nama : '-';
                        },
                    ],
                    [
                        'attribute' => 'id_workcenter',
                        'label' => 'Workcenter',
                        'value' => function ($model) {
                            return $model->workCenter ? $model->workCenter->nama_workcenter : '-';
                        },
                    ],
                    [
                        'attribute' => 'id_shift',
                        'label' => 'Shift',
                        'value' => function ($model) {
                            return $model->shift ? $model->shift->nama_shift : '-';
                        },
                    ],
                    [
                        'attribute' => 'id_wo',
                        'label' => 'WorkOrder',
                        'value' => function ($model) {
                            return $model->workOrder ? $model->workOrder->kode_wo : '-';
                        },
                    ],
                    [
                        'class' => ActionColumn::className(),
                        'urlCreator' => function ($action, ProductionLogWorkerAssignment $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'id_assignment' => $model->id_assignment]);
                        }
                    ],
                ],
            ]); ?>

        </div>
    </div>



    <p>
    </p>




</div>