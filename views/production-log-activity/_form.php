<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ProductionLogActivity $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="production-log-activity-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_log')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'id_routing_detail')->textInput() ?>

    <?= $form->field($model, 'qty_output_total')->textInput() ?>

    <?= $form->field($model, 'durasi_menit')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>