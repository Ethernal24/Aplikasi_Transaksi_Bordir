<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ProdukCustomPelangganSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="produk-custom-pelanggan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'produk_custom_pelanggan_id') ?>

    <?= $form->field($model, 'pelanggan_id') ?>

    <?= $form->field($model, 'kode_barang') ?>

    <?= $form->field($model, 'nama_barang_custom') ?>

    <?= $form->field($model, 'dibuat_pada') ?>

    <?php // echo $form->field($model, 'diupdate_pada') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
