<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\MpsDetailSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="mps-detail-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'mps_detail_id') ?>

    <?= $form->field($model, 'mps_id') ?>

    <?= $form->field($model, 'minggu_ke') ?>

    <?= $form->field($model, 'forecast') ?>

    <?= $form->field($model, 'order_aktual') ?>

    <?php // echo $form->field($model, 'stok') ?>

    <?php // echo $form->field($model, 'rencana_produksi') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
