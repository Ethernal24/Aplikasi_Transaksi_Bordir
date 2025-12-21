<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ProductionLogActivitySearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="production-log-activity-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'activity_id') ?>

    <?= $form->field($model, 'log_id') ?>

    <?= $form->field($model, 'ganti_benang') ?>

    <?= $form->field($model, 'ganti_kain') ?>

    <?= $form->field($model, 'kendala') ?>

    <?php // echo $form->field($model, 'durasi_menit') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
