<?php

use app\models\Shift;
use app\models\TenagaKerja;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Kehadiran $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="pc-content">
    <div class="card table-card">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="card-body mx-4">
            <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'tanggal')->textInput([
                'type' => 'date',
                'min' => date('Y-m-d'),
            ]) ?>

            <?= $form->field($model, 'tk_id')->dropDownList(
                ArrayHelper::map(TenagaKerja::find()->all(), 'tk_id', 'nama'),
                [

                    'prompt' => 'Pilih Tenaga Kerja...',
                    'class' => 'form-control',
                ]
            ) ?>

            <?= $form->field($model, 'shift_id')->dropDownList(
                ArrayHelper::map(Shift::find()->all(), 'shift_id', 'nama_shift'),
                [
                    'prompt' => 'Pilih Shift...',
                    'class' => 'form-control',
                ]
            ) ?>

            <?= $form->field($model, 'status_kehadiran')->dropDownList(
                [
                    '0' => 'Hadir',
                    '1' => 'Izin',
                    '2' => 'Sakit',
                    '3' => 'Alpha'
                ],
                [
                    'id' => 'dropdown-status',
                    'prompt' => 'Pilih Status Kehadiran',
                    'class' => 'form-control' // Tambahkan class CSS jika diperlukan
                ]
            ) ?>
            <div id="section-jam">
                <?= $form->field($model, 'jam_masuk_real')->textInput(['type' => 'time']) ?>
                <?= $form->field($model, 'jam_pulang_real')->textInput(['type' => 'time']) ?>
            </div>
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
function toggleJam() {
    var status = $('#dropdown-status').val();
    
    // Jika status adalah 3 (Alpha)
    if (status == '3') {
        $('#section-jam').hide(); // Sembunyikan
        $('#section-jam input').val(''); // Kosongkan nilainya
    } else {
        $('#section-jam').show(); // Tampilkan jika bukan Alpha
    }
}

// Jalankan saat dropdown berubah
$('#dropdown-status').on('change', function() {
    toggleJam();
});

// Jalankan saat halaman pertama kali dimuat (untuk mode Update)
toggleJam();
JS;
$this->registerJs($script);
?>