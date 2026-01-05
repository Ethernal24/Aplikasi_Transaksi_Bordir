<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\WorkorderMaterial $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="workorder-material-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'wo_id')->textInput() ?>

    <?= $form->field($model, 'bahan_id')->textInput() ?>

    <?= $form->field($model, 'qty_plan')->textInput() ?>

    <?= $form->field($model, 'qty_aktual')->textInput() ?>

    <?= $form->field($model, 'status_pengambilan_bahan')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
