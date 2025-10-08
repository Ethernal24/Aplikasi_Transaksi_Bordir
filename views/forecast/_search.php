<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ForecastSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="forecast-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'forecast_id') ?>

    <?= $form->field($model, 'barang_id') ?>

    <?= $form->field($model, 'metode') ?>

    <?= $form->field($model, 'mse') ?>

    <?= $form->field($model, 'hasil_forecast') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
