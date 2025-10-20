<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\MrpDetailSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="mrp-detail-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'mrp_detail_id') ?>

    <?= $form->field($model, 'mrp_id') ?>

    <?= $form->field($model, 'bahan_id') ?>

    <?= $form->field($model, 'kebutuhan_kotor') ?>

    <?= $form->field($model, 'stock_tersedia') ?>

    <?php // echo $form->field($model, 'kebutuhan_bersih') ?>

    <?php // echo $form->field($model, 'leadtime') ?>

    <?php // echo $form->field($model, 'planned_order_release') ?>

    <?php // echo $form->field($model, 'planned_order_receipt') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
