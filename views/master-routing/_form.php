<?php

use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


/** @var yii\web\View $this */
/** @var app\models\MasterRouting $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="pc-content">
    <div class="card card-table">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>

        </div>
        <div class="card-body">
            <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
            <div class="row">
                <div class="col">
                    <?= $form->field($model, 'nama_routing')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'deskripsi')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper',
                'widgetBody' => '.container-items',
                'widgetItem' => '.item',
                'limit' => 20,
                'min' => 1,
                'insertButton' => '.add-item',
                'deleteButton' => '.remove-item',
                'model' => $modelDetails[0],
                'formId' => 'dynamic-form',
                'formFields' => ['routing_detail_id', 'routing_id', 'urutan', 'nama_proses', 'mesin_id', 'tenaga_kerja_id', 'waktu_setup_menit', 'waktu_pengerjaan_menit'],
            ]); ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Urutan</th>
                        <th>Nama Proses</th>
                        <th>Mesin</th>
                        <th>Tenaga Kerja</th>
                        <th>Waktu Setup</th>
                        <th>Waktu Pengerjaan</th>
                        <th style>Aksi</th>
                    </tr>
                </thead>
                <tbody class="container-items">
                    <?php foreach ($modelDetails as $i => $detail): ?>
                        <tr class="item">
                            <?= $form->field($detail, "[{$i}]routing_detail_id")->hiddenInput()->label(false) ?>
                            <td>
                                <?= $form->field($detail, "[{$i}]urutan", ['template' => "{input}\n{error}"])
                                    ->textInput(['type' => 'text']) ?>
                            </td>
                            <td>
                                <?= $form->field($detail, "[{$i}]nama_proses", ['template' => "{input}\n{error}"])
                                    ->textInput(['type' => 'text']) ?>
                            </td>
                            <td>
                                <?= $form->field($detail, "[{$i}]mesin_id", ['template' => "{input}\n{error}"])
                                    ->dropDownList(
                                        $dataMesin,
                                        [
                                            'prompt' => 'Pilih Mesin',
                                            'class' => 'form-control tipe-field'
                                        ]
                                    ) ?>
                            </td>
                            <td>
                                <?= $form->field($detail, "[{$i}]tenaga_kerja_id", ['template' => "{input}\n{error}"])
                                    ->dropDownList(
                                        $dataTK,
                                        [
                                            'prompt' => 'Pilih Mesin',
                                            'class' => 'form-control tipe-field'
                                        ]
                                    ) ?>
                            </td>
                            <td>
                                <?= $form->field($detail, "[{$i}]waktu_setup_menit", ['template' => "{input}\n{error}"])
                                    ->textInput(['type' => 'text']) ?>
                            </td>
                            <td>
                                <?= $form->field($detail, "[{$i}]waktu_pengerjaan_menit", ['template' => "{input}\n{error}"])
                                    ->textInput(['type' => 'text']) ?>
                            </td>
                            <td style="text-align:center;">
                                <button type="button" class="remove-item btn btn-danger btn-sm">
                                    <i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="add-item btn btn-success btn-sm">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php DynamicFormWidget::end() ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Back', 'index', ['class' => 'btn btn-secondary']) ?>
            </div>


            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>