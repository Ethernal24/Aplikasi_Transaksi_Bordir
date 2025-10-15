<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\BomCustomSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="bom-custom-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'bom_custom_id') ?>

    <?= $form->field($model, 'permintaan_detail_id') ?>

    <?= $form->field($model, 'bahan_id') ?>

    <?= $form->field($model, 'qty_per_unit') ?>

    <?= $form->field($model, 'unit_id') ?>

    <?php // echo $form->field($model, 'catatan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
