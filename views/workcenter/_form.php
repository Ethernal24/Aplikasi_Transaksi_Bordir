<?php

use app\models\TenagaKerja;
use app\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Workcenter $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="workcenter-form">
    <div class="card table-card">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="card-body mx-4">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'kode_workcenter')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'nama_workcenter')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'tipe_kapasitas')->dropDownList(
                [
                    '0' => 'mesin',
                    '1' => 'orang',
                ],
                [
                    'prompt' => 'Pilih Tipe kapasitas',
                    'class' => 'form-control tipe-field',
                ]
            ) ?>

            <?= $form->field($model, 'keterangann')->textInput(['maxlength' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Back', 'index', ['class' => 'btn btn-secondary']) ?>
            </div>
        </div>
    </div>



    <?php ActiveForm::end(); ?>

</div>