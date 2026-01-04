<?php

use app\models\TenagaKerja;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\TenagaKerjaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Tenaga Kerja';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pc-content">
    <div class="card table-card">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
            <?= Html::a('Create Tenaga Kerja', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="card-body mx-4">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'nama',
                    [
                        'attribute' => 'workcenter_id',
                        'label' => 'Workcenter',
                        'value' => function ($model) {
                            return $model->workCenter->nama_workcenter ?? "-";
                        }
                    ],
                    'jabatan',
                    'kemampuan',
                    'status_kerja' => [
                        'attribute' => 'status_kerja',
                        'label' => 'Status Kerja',
                        'value' => function ($model) {
                            $list = [
                                0 => 'Available',
                                1 => 'Off',
                            ];
                            return $list[$model->status_kerja] ?? null;
                        }
                    ],
                    //'dibuat_pada',
                    //'diupdate_pada',
                    [
                        'class' => ActionColumn::className(),
                        'template' => '{update} {view}',
                        'urlCreator' => function ($action, TenagaKerja $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'tk_id' => $model->tk_id]);
                        }
                    ],
                ],
            ]); ?>
        </div>
    </div>




</div>