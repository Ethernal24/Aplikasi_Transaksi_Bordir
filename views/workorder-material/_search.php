<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\WorkorderMaterialSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="workorder-material-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'wo_mat_id') ?>

    <?= $form->field($model, 'wo_id') ?>

    <?= $form->field($model, 'bahan_id') ?>

    <?= $form->field($model, 'qty_plan') ?>

    <?= $form->field($model, 'qty_aktual') ?>

    <?php // echo $form->field($model, 'status_pengambilan_bahan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
