<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ProductionLogAttendanceSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="production-log-attendance-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'attendance_id') ?>

    <?= $form->field($model, 'tk_id') ?>

    <?= $form->field($model, 'log_id') ?>

    <?= $form->field($model, 'mulai_kerja') ?>

    <?= $form->field($model, 'selesai_kerja') ?>

    <?php // echo $form->field($model, 'waktu_kerja') ?>

    <?php // echo $form->field($model, 'mulai_istirahat') ?>

    <?php // echo $form->field($model, 'selesai_istirahat') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
