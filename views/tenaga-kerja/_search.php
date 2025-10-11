<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TenagaKerjaSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tenaga-kerja-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'tk_id') ?>

    <?= $form->field($model, 'nama') ?>

    <?= $form->field($model, 'jabatan') ?>

    <?= $form->field($model, 'kemampuan') ?>

    <?= $form->field($model, 'status_kerja') ?>


    <?php // echo $form->field($model, 'dibuat_pada') 
    ?>

    <?php // echo $form->field($model, 'diupdate_pada') 
    ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>