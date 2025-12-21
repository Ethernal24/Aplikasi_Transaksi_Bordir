<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ProductionLogDetail $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="production-log-detail-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'log_id')->textInput() ?>

    <?= $form->field($model, 'wo_id')->textInput() ?>

    <?= $form->field($model, 'vs')->textInput() ?>

    <?= $form->field($model, 'stitch')->textInput() ?>

    <?= $form->field($model, 'kuantitas')->textInput() ?>

    <?= $form->field($model, 'bs')->textInput() ?>

    <?= $form->field($model, 'berat')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
