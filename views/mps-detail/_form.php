<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\MpsDetail $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="mps-detail-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'mps_id')->textInput() ?>

    <?= $form->field($model, 'minggu_ke')->textInput() ?>

    <?= $form->field($model, 'forecast')->textInput() ?>

    <?= $form->field($model, 'order_aktual')->textInput() ?>

    <?= $form->field($model, 'stok')->textInput() ?>

    <?= $form->field($model, 'rencana_produksi')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
