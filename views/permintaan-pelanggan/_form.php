<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\PermintaanPelanggan $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="permintaan-pelanggan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'jumlah')->textInput() ?>

    <?= $form->field($model, 'tanggal_permintaan')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
