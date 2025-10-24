<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ProdukCustomPelanggan $model */

$this->title = 'Create Produk Custom Pelanggan';
$this->params['breadcrumbs'][] = ['label' => 'Produk Custom Pelanggans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pc-content">


    <?= $this->render('_form', [
        'model' => $model,
        'modelsBom' => $modelsBom,
        'pelanggan_id' => $pelanggan_id,
        'kode_pelanggan' => $kode_pelanggan,
        'lastNumber' => $lastNumber
    ]) ?>

</div>