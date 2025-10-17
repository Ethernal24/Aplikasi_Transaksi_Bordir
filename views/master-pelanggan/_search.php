<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\MasterPelangganSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="master-pelanggan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'pelanggan_id') ?>

    <?= $form->field($model, 'nama_pelanggan') ?>

    <?= $form->field($model, 'instansi') ?>

    <?= $form->field($model, 'pesenan_terakhir') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
