<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ProductionLogAttendance $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="production-log-attendance-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tk_id')->textInput() ?>

    <?= $form->field($model, 'log_id')->textInput() ?>

    <?= $form->field($model, 'mulai_kerja')->textInput() ?>

    <?= $form->field($model, 'selesai_kerja')->textInput() ?>

    <?= $form->field($model, 'waktu_kerja')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mulai_istirahat')->textInput() ?>

    <?= $form->field($model, 'selesai_istirahat')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
