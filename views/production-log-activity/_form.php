<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ProductionLogActivity $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="production-log-activity-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'log_id')->textInput() ?>

    <?= $form->field($model, 'ganti_benang')->textInput() ?>

    <?= $form->field($model, 'ganti_kain')->textInput() ?>

    <?= $form->field($model, 'kendala')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'durasi_menit')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
