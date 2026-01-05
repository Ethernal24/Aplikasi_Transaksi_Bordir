<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ProductionLogWorkerAssignmentSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="production-log-worker-assignment-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_assignment') ?>

    <?= $form->field($model, 'tanggal_assignment') ?>

    <?= $form->field($model, 'id_tk') ?>

    <?= $form->field($model, 'id_workcenter') ?>

    <?= $form->field($model, 'id_shift') ?>

    <?php // echo $form->field($model, 'id_wo') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
