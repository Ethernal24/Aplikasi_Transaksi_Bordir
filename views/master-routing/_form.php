<?php

use app\models\Barang;
use app\models\Workcenter;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
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
                    <?= $form->field($model, 'kode_routing')->textInput(['maxlength' => true, 'readonly' => true]) ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'produk_id')->widget(Select2::className(), [
                        'data' => ArrayHelper::map(Barang::find()->where(['tipe_barang' => 2])->all(), 'barang_id', 'nama_barang'),
                        // 'size' => Select2::LARGE,
                        'options' => [
                            'placeholder' => 'Pilih Barang...',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ]
                    ]) ?>
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
                'formFields' => [
                    'routing_detail_id',
                    'routing_id',
                    'urutan',
                    'workcenter_id',
                    'standard_time_menit',
                    'waktu_setup_menit',
                    'output_jam',
                    'deskripsi_kerja'
                ],
            ]); ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Urutan</th>
                        <th>Workcenter ID</th>
                        <th>Waktu Setup (Menit)</th>
                        <th>Waktu Standard (Menit/pcs)</th>
                        <th>Output (pcs/jam)</th>
                        <th>Deskripsi Kerja</th>
                        <th style>Aksi</th>
                    </tr>
                </thead>
                <tbody class="container-items">
                    <?php foreach ($modelDetails as $i => $detail): ?>
                        <tr class="item">
                            <td>
                                <?= $form->field($detail, "[{$i}]routing_detail_id")->hiddenInput()->label(false) ?>
                                <?= $form->field($detail, "[{$i}]urutan", ['template' => "{input}\n{error}"])
                                    ->textInput(['type' => 'text']) ?>
                            </td>

                            <td>
                                <?= $form->field($detail, "[{$i}]workcenter_id", ['template' => "{input}\n{error}"])
                                    ->dropDownList(
                                        ArrayHelper::map(Workcenter::find()->all(), 'workcenter_id', 'nama_workcenter'),
                                        [
                                            'prompt' => 'Pilih Nama Workcenter...',
                                            'class' => 'form-control',
                                        ],
                                    ) ?>
                            </td>
                            <td>
                                <?= $form->field($detail, "[{$i}]waktu_setup_menit", ['template' => "{input}\n{error}"])
                                    ->textInput(['type' => 'text']) ?>
                            </td>
                            <td>
                                <?= $form->field($detail, "[{$i}]standard_time_menit", ['template' => "{input}\n{error}"])
                                    ->textInput([
                                        'type' => 'text',
                                        'class' => 'form-control hitung-standard',
                                    ]) ?>
                            </td>
                            <td>
                                <?= $form->field($detail, "[{$i}]output_jam", ['template' => "{input}\n{error}"])
                                    ->textInput([
                                        'type' => 'text',
                                        'class' => 'form-control hasil-output',
                                        'readonly' => true,
                                    ]) ?>
                            </td>
                            <td>
                                <?= $form->field($detail, "[{$i}]deskripsi_kerja", ['template' => "{input}\n{error}"])
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

<?php
$urlKapasitas = Url::to(['get-output-kapasitas']);
$script = <<< JS
$(document).on('change', 'select[id$="-workcenter_id"]', function() {
    var workcenterId = $(this).val();
    var currentRow = $(this).closest('tr'); 
    
    // Target input
    var inputOutput = currentRow.find('.hasil-output');
    var inputStdTime = currentRow.find('.hitung-standard');

    if (workcenterId) {
        $.get('{$urlKapasitas}', {id: workcenterId}, function(data) {
            if (data.success) {
                inputOutput.val(data.output_jam.toFixed(2));
                inputStdTime.val(data.WaktuStd.toFixed(2));
                currentRow.data('is-mesin', data.is_mesin);
                // Jika ada mesin, buat readonly dan ubah warna abu-abu
                if (data.is_mesin) {
                    inputOutput.prop('readonly', true).css('background-color', '#e9ecef');
                    inputStdTime.prop('readonly', true).css('background-color', '#e9ecef');
                } else {
                    inputOutput.prop('readonly', true).css('background-color', '#e9ecef');
                    inputStdTime.prop('readonly', false).css('background-color', '#fff');
                }
            } else {
                inputOutput.val(0).prop('readonly', false).css('background-color', '#fff');
                inputStdTime.val(0).prop('readonly', false).css('background-color', '#fff');
            }
        });
    }
});
$(document).on('input', '.hitung-standard', function() {
    var currentRow = $(this).closest('tr');
    var isMesin = currentRow.data('is-mesin');
    
    // Hanya hitung otomatis jika BUKAN mesin
    if (isMesin === false) {
        var stdTime = parseFloat($(this).val());
        var inputOutput = currentRow.find('.hasil-output');
        
        if (stdTime > 0) {
            var outputJam = 60 / stdTime;
            inputOutput.val(outputJam.toFixed(2));
        } else {
            inputOutput.val(0);
        }
    }
});
JS;
$this->registerJs($script);
?>