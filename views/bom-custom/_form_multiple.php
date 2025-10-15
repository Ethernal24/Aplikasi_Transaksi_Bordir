<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;

/** @var yii\web\View $this */
/** @var app\models\BomCustom[] $models */
/** @var app\models\BomCustom $model */

$this->title = 'Update BOM Custom : ' . $models[0]->permintaan_detail_id
?>

<div class="bom-custom-update">
    <div class="card table-card">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="card-body mx-4">
            <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

            <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_inner',
                'widgetBody' => '.container-items',
                'widgetItem' => '.item',
                'limit' => 50,
                'min' => 1,
                'insertButton' => '.add-item',
                'deleteButton' => '.remove-item',
                'model' => $models[0],
                'formId' => 'dynamic-form',
                'formFields' => ['bom_custom_id', 'permintaan_detail_id', 'bahan_id', 'qty_per_unit', 'unit_id', 'catatan'],
            ]); ?>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="width: 40%;">Nama Bahan</th>
                        <th style="width: 10%;">Qty</th>
                        <th style="width: 10%;">Satuan</th>
                        <th style="width: 30%;">Catatan</th>
                        <th style="width: 10%; text-align:center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="container-items">
                    <?php foreach ($models as $i => $m): ?>
                        <tr class="item">
                            <td>
                                <?= Html::activeHiddenInput($m, "[{$i}]bom_custom_id") ?>
                                <?= Html::activeHiddenInput($m, "[{$i}]permintaan_detail_id") ?>
                                <?= $form->field($m, "[{$i}]bahan_id", ['template' => "{input}\n{error}"])
                                    ->dropDownList(
                                        \yii\helpers\ArrayHelper::map(\app\models\Barang::find()->where(['tipe_barang' => 0])->all(), 'barang_id', 'nama_barang'),
                                        ['prompt' => 'Pilih Bahan']
                                    )->label('Nama Bahan') ?>
                            </td>
                            <td>
                                <?= $form->field($m, "[{$i}]qty_per_unit", ['template' => "{input}\n{error}"])
                                    ->textInput(['type' => 'number', 'step' => 'any']) ?>
                            </td>

                            <td>
                                <?= $form->field($m, "[{$i}]unit_id", ['template' => "{input}\n{error}"])
                                    ->dropDownList(
                                        \yii\helpers\ArrayHelper::map(\app\models\Unit::find()->all(), 'unit_id', 'satuan'),
                                        ['prompt' => 'Pilih Unit']
                                    ) ?>
                            </td>
                            <td>
                                <?= $form->field($m, "[{$i}]catatan", ['template' => "{input}\n{error}"])
                                    ->textInput(['maxlength' => true]) ?>
                            </td>
                            <td style="text-align:center;">
                                <button type="button" class="add-item btn btn-success btn-sm"><i class="fa fa-plus"></i></button>
                                <button type="button" class="remove-item btn btn-danger btn-sm"><i class="fa fa-minus"></i></button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php DynamicFormWidget::end(); ?>
            <div class="form-group mt-3">
                <?= Html::submitButton('Simpan Perubahan', ['class' => 'btn btn-primary']) ?> </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>