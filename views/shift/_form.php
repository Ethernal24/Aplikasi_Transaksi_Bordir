<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Shift $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="shift-form">
    <div class="card card-table">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="card-body">
            <?php $form = ActiveForm::begin([
                'enableClientValidation' => false,
            ]); ?>
            <?= $form->field($model, 'nama_shift')->textInput() ?>
            <?= $form->field($model, 'jam_mulai')->textInput(['type' => 'time', 'id' => 'jam-mulai']) ?>

            <?= $form->field($model, 'jam_selesai')->textInput(['type' => 'time', 'id' => 'jam-selesai']) ?>

            <?= $form->field($model, 'jam_efektif')->textInput(['readonly' => true, 'id' => 'jam-efektif']) ?>
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Back', ['index'], ['class' => 'btn btn-secondary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<?php
$script = <<< JS
function hitungJamEfektif() {
    let start = $('#jam-mulai').val();
    let end = $('#jam-selesai').val();

    if (start && end) {
        let startTime = new Date("1970-01-01 " + start);
        let endTime = new Date("1970-01-01 " + end);
        
        // Hitung selisih dalam milidetik
        let diff = endTime - startTime;
        
        // Konversi ke jam
        let hours = diff / (1000 * 60 * 60);
        
        // Kurangi 1 jam untuk istirahat
        let efektif = hours - 1;

        if (efektif > 0) {
            // Tampilkan hasil dengan 2 angka di belakang koma (misal: 7.50)
            $('#jam-efektif').val(efektif.toFixed(2));
        } else {
            $('#jam-efektif').val("0");
        }
    }
}

$('#jam-mulai, #jam-selesai').on('change', function() {
    hitungJamEfektif();
});
JS;
$this->registerJs($script);
?>