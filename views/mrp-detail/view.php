<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\MrpDetail $model */

$this->title = $model->mrp_detail_id;
$this->params['breadcrumbs'][] = ['label' => 'Mrp Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="mrp-detail-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'mrp_detail_id' => $model->mrp_detail_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'mrp_detail_id' => $model->mrp_detail_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'mrp_detail_id',
            'mrp_id',
            'bahan_id',
            'kebutuhan_kotor',
            'stock_tersedia',
            'kebutuhan_bersih',
            'leadtime:datetime',
            'planned_order_release',
            'planned_order_receipt',
        ],
    ]) ?>

</div>
