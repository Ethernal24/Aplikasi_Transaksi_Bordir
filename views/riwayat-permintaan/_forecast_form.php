<?php

use app\models\Barang;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<div class="riwayat-permintaan-form">
    <?php $form = ActiveForm::begin([
        'id' => 'forecast-form',
        'action' => ['riwayat-permintaan/forecast-process'],
        'enableAjaxValidation' => false,
    ]); ?>

    <?= $form->field($model, 'barang_id')
        ->label('Produk')
        ->widget(Select2::className(), [
            'data' => ArrayHelper::map(
                Barang::find()
                    ->select(['barang_id', 'nama_barang'])
                    ->where(['tipe_barang' => 2])
                    ->orderBy(['nama_barang' => SORT_ASC])
                    ->asArray()
                    ->all(),
                'barang_id',
                'nama_barang'
            ),
            'options' => [
                'placeholder' => 'Pilih Barang...',
                'multiple' => true
            ],
            'pluginOptions' => [
                'allowClear' => true,
                'dropdownParent' => new \yii\web\JsExpression('$("#ajaxModal")')
            ],
        ])
    ?>

    <?= $form->field($model, 'periode')
        ->label('Periode perhitungan')
        ->textInput(['type' => 'number', 'min' => 2]) ?>
    <?= $form->field($model, 'horizon')
        ->label('Periode Prediksi')
        ->textInput(['type' => 'number']) ?>

    <div class="form-group">
        <?= Html::submitButton('Proses Forecast', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php
$js = <<<JS
$('#forecast-form').on('beforeSubmit', function(e) {
    e.preventDefault();
    let form = $(this);
    $.post(form.attr('action'), form.serialize())
        .done(function(res) {
            if (res.success) {
                alert(res.message);
                $('#ajaxModal').modal('hide');
                location.reload();
            } else {
                alert('Terjadi kesalahan: ' + res.message);
            }
        });
    return false;
});
JS;
$this->registerJs($js);
?>