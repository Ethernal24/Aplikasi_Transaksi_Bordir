<?php

use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Mps $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="mps-form">
    <div class="card table-card">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="card-body mx-4">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'barang_id')->hiddenInput()->label(false) ?>
            <?= $form->field($model, 'barangName')->textInput([
                'readonly' => true,
                'placeholder' => $model->barangRelasi ? $model->barangName : '-',
            ])->label('Nama Barang') ?>



            <?= $form->field($model, 'periode')->widget(DatePicker::className(), [
                'dateFormat' => 'yyyy-MM-dd',
                'options' => [
                    'class' => 'form-control',
                    'placeholder' => 'Pilih Tanggal',
                    'readonly' => true, // tidak bisa diketik
                    'disabled' => true, // jika ingin benar-benar nonaktif
                ],
            ]) ?>


            <?= $form->field($model, 'tanggal_awal')->widget(DatePicker::className(), [
                'dateFormat' => 'yyyy-MM-dd',
                'options' => [
                    'class' => 'form-control',
                    'placeholder' => 'Pilih Tanggal',
                ],
            ]) ?>

            <?php if ($model->tipe == 0): ?>

                <?= $form->field($model, 'qty')->textInput() ?>

            <?php else: ?>

                <?= $form->field($model, 'qty')->textInput(['readonly' => true]) ?>

            <?php endif; ?>


            <?= $form->field($model, 'tipe')->textInput()->dropDownList([
                0 => 'MTS',
                1 => 'MTO',

            ], [
                'options' => [
                    'class' => 'form-control',
                    'prompt' => 'Pilih Status',

                ],
                'disabled' => true,
            ]) ?>


            <?= $form->field($model, 'dateline')->widget(DatePicker::className(), [
                'dateFormat' => 'yyyy-MM-dd',
                'options' => [
                    'class' => 'form-control',
                    'placeholder' => 'Pilih Tanggal',
                    'readonly' => true, // tidak bisa diketik
                    'disabled' => true, // jika ingin benar-benar nonaktif
                ],
            ]) ?>


            <?= $form->field($model, 'sumber')->textInput(['readonly' => true]) ?>


            <?= $form->field($model, 'status_mps')->dropDownList([
                0 => 'Draft',
                1 => 'Approve',

            ], [
                'options' => [
                    'class' => 'form-control',
                    'prompt' => 'Pilih Status',
                ]
            ]) ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Back', 'index', ['class' => 'btn btn-secondary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>



</div>