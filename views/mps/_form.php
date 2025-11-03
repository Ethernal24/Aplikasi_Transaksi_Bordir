<?php

use wbraganca\dynamicform\DynamicFormWidget;
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
            <div class="row">
                <div class="col">
                    <?= $form->field($model, 'barangName')->textInput([
                        'readonly' => true,
                        'placeholder' => $model->barangRelasi ? $model->barangName : '-',
                    ])->label('Nama Barang') ?>
                    <?= $form->field($model, 'barang_id')->hiddenInput()->label(false) ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'periode')->widget(DatePicker::className(), [
                        'dateFormat' => 'yyyy-MM-dd',
                        'options' => [
                            'class' => 'form-control',
                            'placeholder' => 'Pilih Tanggal',
                            'readonly' => true, // tidak bisa diketik
                        ],
                    ]) ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'tanggal_awal')->widget(DatePicker::className(), [
                        'dateFormat' => 'yyyy-MM-dd',
                        'options' => [
                            'class' => 'form-control',
                            'placeholder' => 'Pilih Tanggal',
                        ],
                    ]) ?>
                </div>
                <div class="col">
                    <?php if ($model->tipe == 0): ?>

                        <?= $form->field($model, 'qty')->textInput() ?>

                    <?php else: ?>

                        <?= $form->field($model, 'qty')->textInput(['readonly' => true]) ?>

                    <?php endif; ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'tipe')->textInput()->dropDownList([
                        0 => 'MTS',
                        1 => 'MTO',

                    ], [
                        'options' => [
                            'class' => 'form-control',
                            'prompt' => 'Pilih Status',

                        ],
                    ]) ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'dateline')->widget(DatePicker::className(), [
                        'dateFormat' => 'yyyy-MM-dd',
                        'options' => [
                            'class' => 'form-control',
                            'placeholder' => 'Pilih Tanggal',
                            'readonly' => true, // tidak bisa diketik
                        ],
                    ]) ?>

                </div>
                <div class="col">
                    <?= $form->field($model, 'sumber')->textInput(['readonly' => true]) ?>

                </div>
                <div class="col">

                    <?= $form->field($model, 'status_mps')->dropDownList([
                        0 => 'Draft',
                        1 => 'Approve',

                    ], [
                        'options' => [
                            'class' => 'form-control',
                            'prompt' => 'Pilih Status',
                        ]
                    ]) ?>
                </div>
            </div>
            <div class="table-responsive">
                <?php DynamicFormWidget::begin([
                    'widgetContainer' => 'dynamicform_wrapper',
                    'widgetBody' => '.container-items',
                    'widgetItem' => '.item',
                    'limit' => 20,
                    'min' => 1,
                    'model' => $details[0],
                    'formId' => 'dynamic-form',
                    'formFields' => ['mps_id', 'minggu_ke', 'forecast', 'order_aktual', 'stok', 'rencana_produksi'],
                ]); ?>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width: 20%;">Minggu Ke</th>
                            <th style="width: 20%;">Forecast</th>
                            <th style="width: 20%;">Order Aktual</th>
                            <th style="width: 20%;">Stok</th>
                            <th style="width: 20%;">Rencana Produksi</th>
                        </tr>
                    </thead>
                    <tbody class="container-items">
                        <?php foreach ($details as $i => $detail): ?>
                            <tr class="item" data-pab="<?= $detail->stok ?>" data-forecast="<?= $detail->forecast ?>" data-aktual="<?= $detail->order_aktual ?>" data-week="<?= $detail->minggu_ke ?>">

                                <?= Html::activeHiddenInput($detail, "[{$i}]mps_id") ?>
                                <td>
                                    <?= $form->field($detail, "[{$i}]minggu_ke", ['template' => "{input}\n{error}"])
                                        ->textInput(['readonly' => true]) ?>
                                </td>
                                <td>
                                    <?= $form->field($detail, "[{$i}]forecast", ['template' => "{input}\n{error}"])
                                        ->textInput(['readonly' => true]) ?>
                                </td>
                                <td>
                                    <?= $form->field($detail, "[{$i}]order_aktual", ['template' => "{input}\n{error}"])
                                        ->textInput(['class' => 'form-control order_aktual']) ?>
                                </td>
                                <td>
                                    <?= $form->field($detail, "[{$i}]stok", ['template' => "{input}\n{error}"])
                                        ->textInput(['readonly' => true, 'class' => 'form-control stok']) ?>
                                </td>
                                <td>
                                    <?= $form->field($detail, "[{$i}]rencana_produksi", ['template' => "{input}\n{error}"])
                                        ->textInput(['class' => 'form-control rencana_produksi']) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php DynamicFormWidget::end(); ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Back', ['view', 'mps_id' => $model->mps_id], ['class' => 'btn btn-secondary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<?php
$this->registerJs(
    <<<JS
    $('.dynamicform_wrapper').on('change', '.order_aktual', function(){
        let row = $(this).closest('tr');
        let forecast = parseFloat(row.data('forecast'));
        let pab = parseFloat(row.data('pab'));
        let week = parseInt(row.data('week'));
        let orderAktual = parseFloat($(this).val()) || 0;

        let rencana = Math.max(forecast, orderAktual) * 1.5;
        row.find('.rencana_produksi').val(Math.round(rencana));
        
        let stok = pab+rencana - orderAktual;
        row.find('.stok').val(Math.round(stok));
        
        let nextRow = row.next('tr');
        if(nextRow.length){
            nextRow.data('pab', stok);
            let nextInput = nextRow.find('.order_aktual')
            if(nextInput.val() !== ''){
                nextInput.trigger('change');
            }
        }
    })

    $('.dynamicform_wrapper').on('change', '.rencana_produksi', function(){
        let row = $(this).closest('tr');
        let forecast = parseFloat(row.data('forecast'));
        let pab = parseFloat(row.data('pab'));
        let orderAktual = parseFloat(row.find('.order_aktual').val()) || 0;
        let rencanaProduksi = parseFloat($(this).val()) || 0;

        let stok = pab+rencanaProduksi - orderAktual;
        row.find('.stok').val(Math.round(stok));

        let nextRow = row.next('tr');
        if(nextRow.length){
            nextRow.data('pab', stok);
            let nextInput = nextRow.find('.order_aktual')
            if(nextInput.val() !== ''){
                nextInput.trigger('change');
            }
        } 
    })
JS
); ?>