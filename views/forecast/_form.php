<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Forecast $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="forecast-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'barang_id')->textInput() ?>

    <?= $form->field($model, 'metode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mse')->textInput() ?>

    <?= $form->field($model, 'hasil_forecast')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
