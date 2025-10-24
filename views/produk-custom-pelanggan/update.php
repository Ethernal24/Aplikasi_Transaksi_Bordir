<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ProdukCustomPelanggan $model */

$this->title = 'Update Produk Custom Pelanggan: ' . $pelanggan->nama_pelanggan;
$this->params['breadcrumbs'][] = ['label' => 'Produk Custom Pelanggan', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $pelanggan->pelanggan_id, 'url' => ['master-pelanggan/view', 'pelanggan_id' => $pelanggan->pelanggan_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pc-content">

    <?= $this->render('_form', [
        'pelanggan' => $pelanggan,
        'model' => $model,
        'modelsBom' => $modelsBom,
        'pelanggan_id' => $pelanggan_id,
        'kode_pelanggan' => $kode_pelanggan,
        'lastNumber' => $lastNumber
    ]) ?>

</div>