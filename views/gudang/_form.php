<?php

use app\models\Barang;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Url;


/** @var yii\web\View $this */
/** @var app\models\Gudang $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="pc-content">
    <div class="card table-card">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="card-body mx-4">
            <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'tanggal')->textInput(['type' => 'date']); ?>


            <?php
            $dataPost = ArrayHelper::map(
                Barang::find()
                    ->where(['tipe_barang' => 0]) // Tambahkan kondisi filter di sini
                    ->asArray()
                    ->all(),
                'barang_id',
                function ($model) {
                    return $model['kode_barang'] . ' - ' . $model['nama_barang'];
                }
            );

            echo $form->field($model, 'barang_id')->widget(Select2::classname(), [
                'data' => $dataPost,
                'options' => [
                    'placeholder' => 'Pilih Bahan Baku ...',
                    'id' => 'barang_id'
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>



            <?php
            // Menampilkan user_id dan username di satu text field (readonly)
            $user_info = Yii::$app->user->id . ' - ' . Yii::$app->user->identity->nama_pengguna;
            echo $form->field($model, 'user_info')->textInput(['value' => $user_info, 'readonly' => true, 'label' => 'user']) ?>


            <?= $form->field($model, 'user_id')->hiddenInput(['value' => Yii::$app->user->id])->label(false) ?>


            <?= $form->field($model, 'quantity_awal')->textInput(['id' => 'qty_awal', 'readonly' => true]) ?>

            <?= $form->field($model, 'quantity_masuk')->textInput(['id' => 'qty_masuk']) ?>

            <?= $form->field($model, 'quantity_keluar')->textInput(['id' => 'qty_keluar']) ?>

            <?= $form->field($model, 'quantity_akhir')->textInput(['readonly' => true, 'id' => 'qty_akhir']) ?>

            <?= $form->field($model, 'catatan')->textInput(['maxlength' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Back', ['gudang/index'], ['class' => 'btn btn-secondary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <!-- Menambahkan tanggal menggunakan datepicker -->


    <?php
    $this->registerJs("
        function calculateQtyAkhir() {
            var quantity_masuk = parseFloat($('#qty_masuk').val()) || 0;
            var quantity_keluar = parseFloat($('#qty_keluar').val()) || 0;
            var quantity_awal = parseFloat($('#qty_awal').val()) || 0;
            var quantity_akhir = quantity_awal+quantity_masuk-quantity_keluar;
            $('#qty_akhir').val(quantity_akhir);
        }

        $('#qty_masuk, #qty_keluar').on('input', calculateQtyAkhir);
    ");
    ?>

    <?php
    $urlGetStock = Url::to(['gudang/get-stock']);
    $this->registerJs("
        $('#barang_id').change(function() {
            var barang_id = $(this).val();
            var url = '$urlGetStock';
            
            // Debug log untuk memastikan URL dan barang_id
            console.log('Request URL: ' + url);
            console.log('Barang ID: ' + barang_id);
            
            // Mengirimkan request AJAX ke controller
            $.post(url, { barang_id: barang_id }, function(data) {
                if (data.quantity_akhir !== null) {
                    // Jika quantity_akhir ada, masukkan ke field stock
                    $('#qty_awal').val(data.quantity_akhir);
                } else {
                    // Jika tidak ada stock, kosongkan atau beri notifikasi
                    $('#qty_awal').val(0);
                    console.warn('Stock tidak ditemukan untuk barang_id ' + barang_id);
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                // Handle error pada request AJAX
                console.error('AJAX error: ', textStatus, errorThrown);
                console.log(jqXHR.responseText); // Debug response text
            });
        });
    ");
    ?>

</div>