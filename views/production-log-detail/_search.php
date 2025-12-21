<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ProductionLogDetailSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="production-log-detail-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'detail_id') ?>

    <?= $form->field($model, 'log_id') ?>

    <?= $form->field($model, 'wo_id') ?>

    <?= $form->field($model, 'vs') ?>

    <?= $form->field($model, 'stitch') ?>

    <?php // echo $form->field($model, 'kuantitas') ?>

    <?php // echo $form->field($model, 'bs') ?>

    <?php // echo $form->field($model, 'berat') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
