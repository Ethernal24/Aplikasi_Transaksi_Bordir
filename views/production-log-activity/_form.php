<?php

use app\models\RoutingDetail;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

use function PHPSTORM_META\map;

/** @var yii\web\View $this */
/** @var app\models\ProductionLogActivity $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="production-log-activity-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_log')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'id_routing_detail')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(RoutingDetail::find()->all(), 'routing_detail_id', 'deskripsi_kerja'),
        'options' => [
            'disabled' => true,
        ],
    ])->label('Aktivitas Kerja') ?>
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

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$target = $sisaReal;
$script = <<< JS

        $(document).on('input', '#productionlogactivity-qty_output_total', function(){
            let target = $target;
            let input = $(this).val();



            if (!input) input = 0
            let sisa = target - input;

            $('#sisa-target-display').text('Sisa: ' + sisa);
            if(sisa < 0 ){
                input = $target
                $('#warning-msg').fadeIn();
                $('#sisa-target-display').css('color', 'red')
                $('button[type="submit"]').prop('disabled', true).addClass('disabled');
            }else{
                $('#warning-msg').fadeOut();
                $('#sisa-target-display').css('color', '#888')
                $('button[type="submit"]').prop('disabled', false).removeClass('disabled');
            }
        });
JS;
$this->registerJs($script);
?>