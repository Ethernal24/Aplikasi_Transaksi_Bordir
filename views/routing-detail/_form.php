<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\RoutingDetail $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="routing-detail-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'routing_id')->textInput() ?>

    <?= $form->field($model, 'urutan')->textInput() ?>

    <?= $form->field($model, 'nama_proses')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mesin_id')->textInput() ?>

    <?= $form->field($model, 'tenaga_kerja_id')->textInput() ?>

    <?= $form->field($model, 'waktu_setup_menit')->textInput() ?>

    <?= $form->field($model, 'waktu_operasi_menit_per_unit')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
