<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\JadwalSimulasi $model */

$this->title = $model->simulasi_id;
$this->params['breadcrumbs'][] = ['label' => 'Jadwal Simulasis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="jadwal-simulasi-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'simulasi_id' => $model->simulasi_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'simulasi_id' => $model->simulasi_id], [
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
            'simulasi_id',
            'produk_id',
            'quantity',
            'tanggal_mulai',
            'dateline',
            'estimasi_selesai',
        ],
    ]) ?>

</div>
