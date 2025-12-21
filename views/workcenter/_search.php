<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\WorkcenterSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="workcenter-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'workcenter_id') ?>

    <?= $form->field($model, 'kode_workcenter') ?>

    <?= $form->field($model, 'nama_workcenter') ?>

    <?= $form->field($model, 'tipe_kapasitas') ?>

    <?= $form->field($model, 'tk_id') ?>

    <?php // echo $form->field($model, 'keterangann') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
