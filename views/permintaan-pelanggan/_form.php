<?php

use app\models\Barang;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\PermintaanPelanggan $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="permintaan-pelanggan-form">

    <div class="card table-card">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="card-body mx-4">
            <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

            <div class="row">
                <div class="col">
                    <?= $form->field($model, 'kode_permintaan')->textInput(['readonly' => true]) ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'pelanggan_id')->dropDownList(
                        ArrayHelper::map(\app\models\MasterPelanggan::find()->all(), 'pelanggan_id', 'nama_pelanggan'),
                        ['prompt' => 'Pilih Pelanggan', 'id' => 'pelanggan-id']
                    )->label('Nama Pelanggan') ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'tanggal_permintaan')->textInput([
                        'type' => 'date',
                        'id' => 'tanggal_permintaan',
                        'min' => date('Y-m-d')
                    ]) ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'tenggat_waktu')->textInput([
                        'type' => 'date',
                        'id' => 'tenggat_waktu',
                        'min' => date('Y-m-d')
                    ]) ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'status_pesanan')->dropDownList(
                        $list = [
                            '0' => 'Antrian',
                            '1' => 'Proses',
                            '2' => 'Selesai',
                        ],
                        [
                            'prompt' => 'Pilih status pesanan...',
                            'class' => 'form-control',
                        ]
                    ) ?>
                </div>
            </div>

            <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper',
                'widgetBody' => '.container-items',
                'widgetItem' => '.item',
                'limit' => 20,
                'min' => 1,
                'insertButton' => '.add-item',
                'deleteButton' => '.remove-item',
                'model' => $modelDetails[0],
                'formId' => 'dynamic-form',
                // Pastikan SEMUA field detail didaftarkan di sini
                'formFields' => [
                    'produk_id',
                    'jumlah',
                    'deskripsi',
                ],
            ]); ?>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="width: 40%;">Produk</th>
                        <th style="width: 15%;">Jumlah</th>
                        <th style="width: 35%;">Deskripsi</th>
                        <th style="width: 10%; text-align:center;">
                            <button type="button" class="add-item btn btn-success btn-xs">
                                <i class="fa fa-plus"></i> Tambah
                            </button>
                        </th>
                    </tr>
                </thead>
                <tbody class="container-items">
                    <?php foreach ($modelDetails as $i => $detail): ?>
                        <tr class="item">
                            <?php
                            // Penting untuk menyertakan ID jika ini adalah mode Update
                            if (! $detail->isNewRecord) {
                                echo Html::activeHiddenInput($detail, "[{$i}]permintaan_detail_id"); // ganti 'id' dengan primary key detail Anda
                            }
                            ?>
                            <td>
                                <?= $form->field($detail, "[{$i}]produk_id", ['template' => "{input}\n{error}"])
                                    ->dropDownList(
                                        ArrayHelper::map(Barang::find()->where(['tipe_barang' => 2])->all(), 'barang_id', 'nama_barang'),
                                        ['prompt' => 'Pilih produk', 'class' => 'barang-dropdown form-control']
                                    ) ?>
                            </td>
                            <td>
                                <?= $form->field($detail, "[{$i}]jumlah", ['template' => "{input}\n{error}"])
                                    ->textInput(['type' => 'number', 'min' => 1]) ?>
                            </td>
                            <td>
                                <?= $form->field($detail, "[{$i}]deskripsi", ['template' => "{input}\n{error}"])
                                    ->textInput() ?>
                            </td>
                            <td style="text-align:center;">
                                <button type="button" class="remove-item btn btn-danger btn-sm">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <?php DynamicFormWidget::end(); ?>

            <div class="form-group mt-3">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Back', $model->isNewRecord ? ['index'] : ['view', 'permintaan_id' => $model->permintaan_id], ['class' => 'btn btn-secondary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<?php
$js = <<<JS
$('#tanggal_permintaan').on('change', function(){
    let startDate = $(this).val();
    if (startDate) {
        $('#tenggat_waktu').attr('min', startDate);
        let endDate = $('#tenggat_waktu').val();
        if (endDate && endDate < startDate) {
            $('#tenggat_waktu').val('');
        }
    }
});

JS;
$this->registerJs($js)

// $urlGetBarang = Url::to(['permintaan-pelanggan/get-barang-by-pelanggan']);
// $js = <<<JS
//     $('#pelanggan-id').on('change', function() {
//     var pelangganId = $(this).val();

//     if (!pelangganId) {
//         // reset semua dropdown barang jika pelanggan belum dipilih
//         $('.barang-dropdown').html('<option value="">Pilih Barang</option>');
//         return;
//     }

//     $.ajax({
//         url: '{$urlGetBarang}',
//         type: 'GET',
//         data: { pelanggan_id: pelangganId },
//         success: function(response) {
//             $('.barang-dropdown').each(function() {
//                 $(this).html(response); // isi ulang semua dropdown barang
//             });
//         },
//         error: function() {
//             alert('Gagal mengambil data barang.');
//         }
//     });
// });
// JS;
// $this->registerJs($js);
?>