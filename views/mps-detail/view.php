<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\MpsDetail $model */

$this->title = $model->mps_detail_id;
$this->params['breadcrumbs'][] = ['label' => 'Mps Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="mps-detail-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'mps_detail_id' => $model->mps_detail_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'mps_detail_id' => $model->mps_detail_id], [
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
            'mps_detail_id',
            'mps_id',
            'minggu_ke',
            'forecast',
            'order_aktual',
            'stok',
            'rencana_produksi',
        ],
    ]) ?>

</div>
