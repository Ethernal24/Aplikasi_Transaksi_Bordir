<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\MpsDetailAllocation $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="mps-detail-allocation-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'mps_detail_id')->textInput() ?>

    <?= $form->field($model, 'workcenter_id')->textInput() ?>

    <?= $form->field($model, 'qty_mesin_alokasi')->textInput() ?>

    <?= $form->field($model, 'qty_karyawan_alokasi')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
