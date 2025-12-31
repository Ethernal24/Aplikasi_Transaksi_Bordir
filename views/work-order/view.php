<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\WorkOrder $model */

$this->title = $model->id_wo;
$this->params['breadcrumbs'][] = ['label' => 'Work Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="work-order-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_wo' => $model->id_wo], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_wo' => $model->id_wo], [
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
            'id_wo',
            'kode_wo',
            'id_produk',
            'id_routing',
            'qty_target',
            'tanggal_wo',
            'due_date',
            'status_wo',
            'prioritas',
            'id_pelanggan',
            'created_at',
        ],
    ]) ?>

</div>
