<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\KehadiranSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="kehadiran-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'kehadiran_id') ?>

    <?= $form->field($model, 'tanggal') ?>

    <?= $form->field($model, 'tk_id') ?>

    <?= $form->field($model, 'shift_id') ?>

    <?= $form->field($model, 'status_kehadiran') ?>

    <?php // echo $form->field($model, 'jam_masuk_real') ?>

    <?php // echo $form->field($model, 'jam_pulang_real') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
