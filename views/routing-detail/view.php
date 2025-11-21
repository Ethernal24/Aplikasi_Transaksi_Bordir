<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\RoutingDetail $model */

$this->title = $model->routing_detail_id;
$this->params['breadcrumbs'][] = ['label' => 'Routing Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="routing-detail-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'routing_detail_id' => $model->routing_detail_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'routing_detail_id' => $model->routing_detail_id], [
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
            'routing_detail_id',
            'routing_id',
            'urutan',
            'nama_proses',
            'mesin_id',
            'tenaga_kerja_id',
            'waktu_setup_menit',
            'waktu_operasi_menit_per_unit',
        ],
    ]) ?>

</div>
