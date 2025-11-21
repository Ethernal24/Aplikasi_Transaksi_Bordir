<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\RoutingDetailSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="routing-detail-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'routing_detail_id') ?>

    <?= $form->field($model, 'routing_id') ?>

    <?= $form->field($model, 'urutan') ?>

    <?= $form->field($model, 'nama_proses') ?>

    <?= $form->field($model, 'mesin_id') ?>

    <?php // echo $form->field($model, 'tenaga_kerja_id') ?>

    <?php // echo $form->field($model, 'waktu_setup_menit') ?>

    <?php // echo $form->field($model, 'waktu_operasi_menit_per_unit') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
