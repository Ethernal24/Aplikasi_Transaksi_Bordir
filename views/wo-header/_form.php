<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\WoHeader $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="wo-header-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kode_wo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'produk_id')->textInput() ?>

    <?= $form->field($model, 'tanggal_dibuat')->textInput() ?>

    <?= $form->field($model, 'tanggal_selesai')->textInput() ?>

    <?= $form->field($model, 'status_wo')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
