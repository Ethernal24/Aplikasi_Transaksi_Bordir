<?php

use app\models\Shift;
use app\models\TenagaKerja;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

use yii\helpers\Html;
?>

<div class="attendance-form">
    <?php $form = ActiveForm::begin(['id' => 'absen-cepat-form']); ?>

    <?= $form->field($model, 'tk_id')->dropDownList(
        ArrayHelper::map(TenagaKerja::find()->all(), 'tk_id', 'nama'),
        ['prompt' => '-- Pilih Tenaga Kerja --', 'class' => 'form-control select2']
    )->label('Pilih Karyawan') ?>
    <?= $form->field($model, 'shift_id')->dropDownList(
        ArrayHelper::map(Shift::find()->all(), 'shift_id', 'nama_shift'),
        ['prompt' => 'Pilih Shift...', 'class' => 'form-control select2']
    ) ?>

    <div class="form-group mt-3">
        <?= Html::submitButton('Simpan Absensi', ['class' => 'btn btn-primary btn-block']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php
$script = <<< JS
$('#absen-cepat-form').on('beforeSubmit', function(e) {
    var form = $(this);
    $.post(
        form.attr('action'),
        form.serialize()
    ).done(function(result) {
        if(result.success) {
            Swal.fire({
                title: 'Berhasil!',
                text: result.message,
                icon: 'success',
                target: document.getElementById('modal') // Menargetkan modal agar alert muncul di depannya
            }).then(() => {
                $('#modal').modal('hide');
                location.reload();
            });
        } else {
            Swal.fire({
                title: 'Peringatan!',
                text: result.message,
                icon: 'warning',
                target: document.getElementById('modal') // Menargetkan modal
            });
        }
    }).fail(function() {
        Swal.fire({
            title: 'Error!',
            text: 'Terjadi kesalahan sistem.',
            icon: 'error',
            target: document.getElementById('modal')
        });
    });
    return false;
});
JS;
$this->registerJs($script);
?>