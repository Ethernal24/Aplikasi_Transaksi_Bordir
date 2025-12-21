<?php

use app\models\Barang;
use app\models\Workcenter;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\ArrayHelper;
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
                'formFields' => ['routing_detail_id', 'routing_id', 'urutan', 'workcenter_id',  'standard_time_menit', 'waktu_setup_menit', 'output_jam'],
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
                            <?= $form->field($detail, "[{$i}]routing_detail_id")->hiddenInput()->label(false) ?>
                            <td>
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
$script = <<< JS
$(document).on('input', '.hitung-standard', function() {
    // Ambil baris (row) tempat input ini berada
    let row = $(this).closest('tr');
    
    // Ambil nilai standard
    let std = parseFloat($(this).val());
    
    // Logika Hitung: 60 / Standard
    if (std > 0) {
        let hasil = 60 / std;
        // Set hasil ke input output_jam di baris yang sama, batasi 2 angka di belakang koma
        row.find('.hasil-output').val(hasil);
    } else {
        row.find('.hasil-output').val(0);
    }
});
JS;
$this->registerJs($script);
?>