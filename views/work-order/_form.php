<?php

use app\models\MasterRouting;
use app\models\PermintaanDetail;
use app\models\PermintaanPelanggan;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\WorkOrder $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="pc-content">
    <div class="card table-card">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="card-body mx-4">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'kode_wo')->textInput(['maxlength' => true]) ?>


            <?= $form->field($model, 'id_routing')->dropDownList(
                ArrayHelper::map(MasterRouting::find()->all(), 'routing_id', 'kode_routing'),
                [
                    'prompt' => 'Pilih Kode Routing'
                ]
            )->label('Kode Routing') ?>


            <!-- <?= $form->field($model, 'permintaan_id')->dropDownList(
                        ArrayHelper::map(PermintaanPelanggan::find()->all(), 'permintaan_id', 'kode_permintaan'),
                        [
                            'id' => 'id-permintaan',
                            'prompt' => 'Pilih Kode Permintaan...',
                            'onchange' => "
                        $.get('" . \yii\helpers\Url::to(['work-order/get-barang']) . "', { id: $(this).val() })
                        .done(function(data) {
                            $('#id-permintaan-detail').html(data).prop('disabled', false);
                        })
                        .fail(function() {
                            alert('Gagal mengambil data barang');
                        });
                    "
                        ]
                    ) ?> -->

            <?= $form->field($model, 'permintaan_id')->dropDownList(
                [],
                [
                    'id' => 'id-permintaan-detail',
                    'prompt' => 'Pilih Barang...',
                ]
            ) ?>

            <?= $form->field($model, 'qty_target')->textInput(['id' => 'qty-target', 'readonly' => true]) ?>

            <?= $form->field($model, 'due_date')->textInput(['id' => 'due-date', 'readonly' => true]) ?>
            <?= $form->field($model, 'tanggal_wo')->textInput(['type' => 'date']) ?>

            <?= $form->field($model, 'status_wo')->dropDownList(
                $list = [
                    '0' => 'Draft',
                    '1' => "Rilis",
                    '2' => 'Berjalan',
                    '3' => 'Selesai',
                    '4' => 'Batal',
                ],
                [
                    'prompt' => 'Pilih Status Work Order',
                    'class' => 'form-control',
                ]
            ) ?>

            <?= $form->field($model, 'prioritas')->dropDownList(
                $list = [
                    '0' => 'Low',
                    '1' => "Medium",
                    '2' => 'High',
                    '3' => 'Urgent',
                ],
                [
                    'prompt' => 'Pilih Status Work Order',
                    'class' => 'form-control',
                ]
            ) ?>


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
    var dataKatalog = {};

    $('#id-permintaan').change(function() {
        var id = $(this).val();
        
        // Kosongkan field setiap kali permintaan berganti
        $('#id-permintaan-detail').html('<option>Loading...</option>').prop('disabled', true);
        $('#qty-target').val('');
        $('#due-date').val('');

        if(id) {
            $.get('/work-order/get-barang', { id: id }, function(response) {
                var data = JSON.parse(response);
                $('#id-permintaan-detail').html(data.html).prop('disabled', false);
                dataKatalog = data.katalog;
            });
        }
    });

    $('#id-permintaan-detail').change(function() {
        var selectedId = $(this).val();
        
        // Jika selectedId ada di dalam katalog, isi field. Jika tidak (kosong), kosongkan field.
        if (selectedId && dataKatalog[selectedId]) {
            $('#qty-target').val(dataKatalog[selectedId].qty);
            $('#due-date').val(dataKatalog[selectedId].duedate);
        } else {
            $('#qty-target').val('');
            $('#due-date').val('');
        }
    });
JS;
$this->registerJs($script);
?>