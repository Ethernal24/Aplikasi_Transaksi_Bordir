<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\MasterPelanggan $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="master-pelanggan-form">
    <div class="card card-table">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="card-body">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'nama_pelanggan')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'instansi')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'no_telp')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'kode')->textInput(['maxlength' => true]) ?>


            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                <?= Html::a('back', 'index', ['class' => 'btn btn-secondary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>



</div>