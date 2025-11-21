<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\WoHeader $model */

$this->title = $model->wo_id;
$this->params['breadcrumbs'][] = ['label' => 'Wo Headers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="wo-header-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'wo_id' => $model->wo_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'wo_id' => $model->wo_id], [
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
            'wo_id',
            'kode_wo',
            'produk_id',
            'tanggal_dibuat',
            'tanggal_selesai',
            'status_wo',
        ],
    ]) ?>

</div>
