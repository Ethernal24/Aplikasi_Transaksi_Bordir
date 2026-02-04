<?php

use app\models\ProductionLogWorkerAssignment;
use app\models\RoutingDetail;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

use function PHPSTORM_META\map;

/** @var yii\web\View $this */
/** @var app\models\ProductionLogActivity $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="production-log-activity-form">

    <?php $form = ActiveForm::begin([
        'id' => 'production-log-activity-form', // Berikan ID spesifik
        'enableClientValidation' => true,
    ]); ?>

    <?= $form->field($model, 'id_log')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'id_routing_detail')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(RoutingDetail::find()->all(), 'routing_detail_id', 'deskripsi_kerja'),
        'options' => [
            'disabled' => true,
        ],
    ])->label('Aktivitas Kerja') ?>
    <?= $form->field($model, 'id_assignment')->widget(Select2::class, [
        'data' => ArrayHelper::map(
            ProductionLogWorkerAssignment::find()
                ->joinWith('tk')
                ->where(['id_wo' => $model->log->id_wo]) // Pastikan ada relasi 'employee' di model Assignment
                ->all(),
            'id_assignment',
            function ($model) {
                // Menampilkan Nama dari tabel Master_Employee melalui relasi
                return $model->tk->nama;
            }
        ),
        'options' => ['placeholder' => 'Pilih Karyawan...'],
        'pluginOptions' => [
            'allowClear' => true,
            'dropdownParent' => new JsExpression('$("#modal-universal")'),
        ],
    ])->label('Nama Karyawan') ?>
    <?= $form->field($model, 'id_routing_detail')->hiddenInput()->label(false) ?>

    <!-- // Data untuk Server (Database) -->

    <?= $form->field($model, 'qty_output_total', [
        'template' => '
        {label}
        <div class="input-group">
            {input}
            <span id="sisa-target-display" class="input-group-addon" style="
                background-color: transparent; 
                border-left: none; 
                position: absolute; 
                right: 0; 
                top: 0; 
                padding: 10px;
                z-index: 10; 
                height: 100%; 
                display: flex; 
                align-items: center; 
                border: none;
                color: #888;
            ">
                Sisa: 
                ' . $sisaReal . '
            </span>
        </div>
        <div id="warning-msg" style="color: #a94442; font-size: 12px; margin-top: 5px; font-weight: bold; display: none;"> 
            Angka Melebihi target produksi
        </div>
        {error}{hint}
    '
    ])->textInput([
        'style' => 'padding-right: 100px;' // Supaya angka yang diketik tidak tertutup teks Target
    ]) ?>
    <?= $form->field($model, 'vs')->textInput()->label('Variasi') ?>
    <?= $form->field($model, 'stitch')->textInput() ?>
    <?= $form->field($model, 'bs')->textInput()->label('Reject') ?>
    <?= $form->field($model, 'berat')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$target = $sisaReal;
$script = <<< JS

        $(document).on('input', '#productionlogactivity-qty_output_total, #productionlogactivity-bs', function(){
            let target = parseFloat($target) || 0;
            let qtyOutput = parseFloat($('#productionlogactivity-qty_output_total').val()) || 0;
            
            // PASTIKAN ID ini sesuai dengan yang dihasilkan ActiveForm
            let qtyBs = parseFloat($('#productionlogactivity-bs').val()) || 0; 

            // Logika: Sisa hanya berkurang berdasarkan barang bagus (Good Product)
            // Jika sisa dihitung (target - qtyOutput), maka BS tidak memotong jatah target.
            // Jika sisa dihitung (target - (qtyOutput + qtyBs)), maka BS memotong jatah target.
            
            let totalDikerjakan = qtyOutput + qtyBs; 
            let sisa = target - totalDikerjakan;

            $('#sisa-target-display').text('Sisa: ' + sisa);

            if (sisa < 0) {
                $('#warning-msg').text('Input melebihi sisa kapasitas target!').fadeIn();
                $('#sisa-target-display').css('color', 'red');
                $('button[type="submit"]').prop('disabled', true).addClass('disabled');
            } else {
                $('#warning-msg').fadeOut();
                $('#sisa-target-display').css('color', '#888');
                $('button[type="submit"]').prop('disabled', false).removeClass('disabled');
            }
        });
JS;
$this->registerJs($script);
?>