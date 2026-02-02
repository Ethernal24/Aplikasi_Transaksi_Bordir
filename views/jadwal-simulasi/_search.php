<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\JadwalSimulasiSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="jadwal-simulasi-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'simulasi_id') ?>

    <?= $form->field($model, 'produk_id') ?>

    <?= $form->field($model, 'quantity') ?>

    <?= $form->field($model, 'tanggal_mulai') ?>

    <?= $form->field($model, 'dateline') ?>

    <?php // echo $form->field($model, 'estimasi_selesai') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
