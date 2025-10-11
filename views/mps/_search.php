<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\MpsSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="mps-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'mps_id') ?>

    <?= $form->field($model, 'forecast_id') ?>

    <?= $form->field($model, 'stock_awal') ?>

    <?= $form->field($model, 'rencana_produksi') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
