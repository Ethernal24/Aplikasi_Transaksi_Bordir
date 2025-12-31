<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\WorkOrderSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="work-order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_wo') ?>

    <?= $form->field($model, 'kode_wo') ?>

    <?= $form->field($model, 'id_produk') ?>

    <?= $form->field($model, 'id_routing') ?>

    <?= $form->field($model, 'qty_target') ?>

    <?php // echo $form->field($model, 'tanggal_wo') ?>

    <?php // echo $form->field($model, 'due_date') ?>

    <?php // echo $form->field($model, 'status_wo') ?>

    <?php // echo $form->field($model, 'prioritas') ?>

    <?php // echo $form->field($model, 'id_pelanggan') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
