<?php

use app\models\MpsDetail;
use kartik\grid\GridView;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Mps $model */

$this->title = "Detail MPS : " . $model->mps_id;
$this->params['breadcrumbs'][] = ['label' => 'Mps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pc-content">
    <div class="card card-table">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <?= GridView::widget([
                    'dataProvider' => new \yii\data\ArrayDataProvider([
                        'allModels' => $detail,
                        'pagination' => false, // tidak perlu pagination
                    ]),
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn', 'header' => 'No'],

                        [
                            'attribute' => 'mps_id',
                            'label' => 'MPS ID',
                            'value' => 'mps_id',
                        ],
                        [
                            'attribute' => 'minggu_ke',
                            'value' => 'minggu_ke',
                            'label' => 'Minggu Ke',
                        ],
                        [
                            'attribute' => 'forecast',
                            'value' => 'forecast',
                            'label' => 'Forecast',
                        ],
                        [
                            'attribute' => 'order_aktual',
                            'value' => 'order_aktual',
                            'label' => 'Order Aktual',
                        ],
                        [
                            'attribute' => 'stok',
                            'value' => 'stok',
                            'label' => 'Stok',
                        ],
                        [
                            'attribute' => 'rencana_produksi',
                            'value' => 'rencana_produksi',
                            'label' => 'Rencana Produksi',
                        ],
                        [
                            'class' => ActionColumn::className(),
                            'template' => '{update}',
                            'urlCreator' => function ($action, MpsDetail $detail, $key, $index, $column) {
                                return Url::toRoute([$action, 'mps_id' => $detail->mps_id]);
                            }
                        ]
                    ],
                ]);
                ?>
            </div>
            <?= Html::a('Update', ['update', 'mps_id' => $model->mps_id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'mps_id' => $model->mps_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
            <?= Html::a('Back', ['index'], ['class' => 'btn btn-secondary']) ?>
        </div>
    </div>


</div>