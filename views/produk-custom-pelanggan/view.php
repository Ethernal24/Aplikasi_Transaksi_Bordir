<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\ProdukCustomPelanggan $model */

$this->title = $model->produk_custom_pelanggan_id;
$this->params['breadcrumbs'][] = ['label' => 'Produk Custom Pelanggans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="produk-custom-pelanggan-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'produk_custom_pelanggan_id' => $model->produk_custom_pelanggan_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'produk_custom_pelanggan_id' => $model->produk_custom_pelanggan_id], [
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
            'produk_custom_pelanggan_id',
            'pelanggan_id',
            'kode_barang',
            'nama_barang_custom',
            'dibuat_pada',
            'diupdate_pada',
        ],
    ]) ?>

</div>
