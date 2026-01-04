<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\ProductionLogDowntime $model */

$this->title = $model->downtime_id;
$this->params['breadcrumbs'][] = ['label' => 'Production Log Downtimes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="production-log-downtime-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'downtime_id' => $model->downtime_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'downtime_id' => $model->downtime_id], [
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
            'downtime_id:datetime',
            'log_id',
            'ganti_benang',
            'ganti_kain',
            'kendala',
            'durasi_menit',
        ],
    ]) ?>

</div>
