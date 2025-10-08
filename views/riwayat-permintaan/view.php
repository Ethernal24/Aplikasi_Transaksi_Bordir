<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\RiwayatPermintaan $model */

$this->title = $model->riwayat_id;
$this->params['breadcrumbs'][] = ['label' => 'Riwayat Permintaans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="riwayat-permintaan-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'riwayat_id' => $model->riwayat_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'riwayat_id' => $model->riwayat_id], [
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
            'riwayat_id',
            'barang_id',
            'bulan',
            'tahun',
            'jumlah_permintaan',
        ],
    ]) ?>

</div>