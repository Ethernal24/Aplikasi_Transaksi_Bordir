<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\MpsDetailAllocationSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="mps-detail-allocation-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'mps_detail_allocation_id') ?>

    <?= $form->field($model, 'mps_detail_id') ?>

    <?= $form->field($model, 'workcenter_id') ?>

    <?= $form->field($model, 'qty_mesin_alokasi') ?>

    <?= $form->field($model, 'qty_karyawan_alokasi') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
