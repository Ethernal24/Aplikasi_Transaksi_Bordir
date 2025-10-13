<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\MasterRouting $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="master-routing-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nama_routing')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'deskripsi')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
