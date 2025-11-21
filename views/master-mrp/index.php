<?php

use app\models\MasterMrp;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\MasterMrpSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Master Mrp';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pc-content">
    <div class="card table-card">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
            <?= Html::a('Create Master Mrp', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="card-body mx-4">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    // 'mrp_id',
                    // 'mps_id',
                    [
                        'attribute' => 'nama_barang',
                        'value' => function ($model) {
                            return $model->mps->barangName;
                        },
                        'label' => 'nama barang',
                    ],
                    [
                        'attribute' => 'tanggal_awal',
                        'value' => function ($model) {
                            return date('d-M-Y', strtotime($model->mps->tanggal_awal));
                        },
                        'label' => 'Tanggal Awal',
                    ],
                    [
                        'attribute' => 'dateline',
                        'value' => function ($model) {
                            return date('d-M-Y', strtotime($model->mps->dateline));
                        },
                        'label' => 'dateline',
                    ],
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $label = $model->label;
                            return "<span class='{$label['class']}'>{$label['label']}</span>";
                        },
                        'label' => 'Status',
                    ],
                    [
                        'class' => ActionColumn::className(),
                        'template' => '{view}',
                        'urlCreator' => function ($action, MasterMrp $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'mrp_id' => $model->mrp_id]);
                        }
                    ],
                ],
            ]); ?>
        </div>
    </div>






</div>