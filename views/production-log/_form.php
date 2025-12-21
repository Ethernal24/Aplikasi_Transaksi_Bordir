<?php

use app\models\Mesin;
use app\models\Shift;
use app\models\TenagaKerja;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ProductionLog $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="production-log-form">
    <div class="card table-card">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="card-body mx-4">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'tanggal')->textInput(['type' => 'date']) ?>

            <?= $form->field($model, 'mesin_id')
                ->dropDownList(
                    ArrayHelper::map(Mesin::find()->all(), 'mesin_id', 'nama_mesin'),
                    [

                        'prompt' => 'Pilih Mesin...',
                        'class' => 'form-control',
                    ]
                )
                ->label('Mesin') ?>

            <?= $form->field($model, 'tk_id')
                ->dropDownList(
                    ArrayHelper::map(TenagaKerja::find()->all(), 'tk_id', 'nama'),
                    [

                        'prompt' => 'Pilih Tenaga Kerja...',
                        'class' => 'form-control',
                    ]
                )->label('Tenaga Kerja')  ?>

            <?= $form->field($model, 'shift_id')
                ->dropDownList(
                    ArrayHelper::map(Shift::find()->all(), 'shift_id', 'nama_shift'),
                    [

                        'prompt' => 'Pilih Shift...',
                        'class' => 'form-control',
                    ]
                )->label('Shift') ?>
            <?= $form->field($model, 'mulai_kerja')->textInput(['type' => 'time', 'id' => 'mulai-kerja']) ?>

            <?= $form->field($model, 'selesai_kerja')->textInput(['type' => 'time', 'id' => 'selesai-kerja']) ?>

            <?= $form->field($model, 'waktu_kerja')->textInput([
                'maxlength' => true,
                'id' => 'waktu-kerja',
                'readonly' => true,
            ]) ?>

            <?= $form->field($model, 'mulai_istirahat')->textInput(['type' => 'time', 'id' => 'mulai-istirahat']) ?>

            <?= $form->field($model, 'selesai_istirahat')->textInput(['type' => 'time', 'id' => 'selesai-istirahat']) ?>
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Back', ['index'], ['class' => 'btn btn-secondary']) ?>

            </div>
        </div>
    </div>



    <?php ActiveForm::end(); ?>

</div>

<?php
$script = <<< JS
function toHours(timeStr) {
    if (!timeStr) return 0;
    var parts = timeStr.split(':');
    return parseInt(parts[0]) + (parseInt(parts[1]) / 60);
}

function hitungDesimalKerja() {
    var jamMulai = $('#mulai-kerja').val();
    var jamSelesai = $('#selesai-kerja').val();
    var istMulai = $('#mulai-istirahat').val();
    var istSelesai = $('#selesai-istirahat').val();

    if (jamMulai && jamSelesai) {
        var start = toHours(jamMulai);
        var end = toHours(jamSelesai);

        // LOGIKA SHIFT MALAM: Jika selesai < mulai, berarti lewat tengah malam
        var totalKerjaRaw = (end < start) ? (24 - start) + end : end - start;

        // Hitung Pengurang Istirahat
        var totalIstirahat = 0;
        if (istMulai && istSelesai) {
            var iStart = toHours(istMulai);
            var iEnd = toHours(istSelesai);
            totalIstirahat = (iEnd < iStart) ? (24 - iStart) + iEnd : iEnd - iStart;
        }

        // Jam Netto (Jam Kerja - Istirahat)
        var jamNetto = totalKerjaRaw - totalIstirahat;

        if (jamNetto > 0) {
            // Konversi ke Standar 7 Jam
            var desimal = jamNetto / 7;
            
            // Format angka
            var hasil;
            hasil = desimal.toFixed(2); // Custom (seperti 0.33)


            $('#waktu-kerja').val(hasil);
        } else {
            $('#waktu-kerja').val(0);
        }
    }
}   

// Event listener
$('#mulai-kerja, #selesai-kerja, #mulai-istirahat, #selesai-istirahat').on('change', function() {
    hitungDesimalKerja();
});
JS;
$this->registerJs($script);
?>