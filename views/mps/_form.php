<?php

use app\models\Barang;
use app\models\MasterMrp;
use app\models\Mps;
use app\models\PermintaanPelanggan;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
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
            <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
            <div class="row">
                <div class="col">
                    <?= $form->field($model, 'periode')->textInput(['type' => 'date']) ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'kode_mps')->textInput() ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'tanggal_awal')->textInput(['type' => 'date']) ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'tanggal_akhir')->textInput(['type' => 'date']) ?>
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
            <hr>
            <h4>Detail MPS</h4>
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
                'formFields' => [
                    'mps_id',
                    'permintaan_id',
                    'produk_id',
                    'qty_plan',
                ],
            ]); ?>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Permintaan ID</th>
                        <th>Produk ID</th>
                        <th>Qty plan</th>
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
                                echo Html::activeHiddenInput($detail, "[{$i}]mps_detail_id"); // ganti 'id' dengan primary key detail Anda
                            }
                            ?>
                            <td>
                                <?= $form->field($detail, "[{$i}]permintaan_id", ['template' => "{input}\n{error}"])
                                    ->dropDownList(
                                        ArrayHelper::map(
                                            PermintaanPelanggan::find()
                                                ->alias('p')
                                                ->leftJoin('mps_detail md', 'md.permintaan_id = p.permintaan_id')
                                                ->where(['is', 'md.permintaan_id', new \yii\db\Expression('null')])
                                                // Kondisi Tambahan: Jika ini data lama (update), sertakan ID ini agar muncul
                                                ->orWhere(['p.permintaan_id' => $detail->permintaan_id])
                                                ->all(),
                                            'permintaan_id',
                                            'kode_permintaan'
                                        ),
                                        [
                                            'prompt' => 'Pilih Kode permintaan...',
                                            'class' => 'form-control select-permintaan'
                                        ]
                                    ) ?>
                            </td>
                            <td>
                                <?php
                                // Jika sedang update, dropdown produk harus berisi produk yang sudah tersimpan
                                $dataBarang = [];
                                if (!$detail->isNewRecord) {
                                    $dataBarang = [$detail->produk_id => $detail->produk->nama_barang];
                                }

                                echo $form->field($detail, "[{$i}]produk_id", ['template' => "{input}\n{error}"])
                                    ->dropDownList($dataBarang, [
                                        'prompt' => 'Pilih Barang...',
                                        'class' => 'form-control select-produk'
                                    ]);
                                ?>
                            </td>
                            <td>
                                <?= $form->field($detail, "[{$i}]qty_plan", ['template' => "{input}\n{error}"])
                                    ->textInput(['class' => 'form-control input-qty', 'readonly' => true]) // Tambahkan class ini 
                                ?>
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
            <hr>
            <div>
                <h4>Ringkasan Beban Produksi</h4>
                <div class="row">
                    <div class="col-md-6">
                        <label>Beban Tenaga Kerja (Manpower)</label>
                        <div class="progress" style="height: 30px;">
                            <div id="bar-manpower" class="progress-bar bg-success" role="progressbar" style="width: 0%;">0%</div>
                        </div>
                        <small id="text-manpower">0 / 0 Menit</small>
                    </div>
                    <div class="col-md-6">
                        <label>Beban Mesin Utama</label>
                        <div class="progress" style="height: 30px;">
                            <div id="bar-machine" class="progress-bar bg-info" role="progressbar" style="width: 0%;">0%</div>
                        </div>
                        <small id="text-machine">0 / 0 Menit</small>
                    </div>
                </div>
                <div id="alert-overload" class="alert alert-danger mt-3" style="display:none;">
                    <strong>Peringatan!</strong> Beban melebihi kapasitas tersedia pada rentang tanggal tersebut.
                </div>
            </div>
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Back', ['index', 'mps_id' => $model->mps_id], ['class' => 'btn btn-secondary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<?php
$getPermintaanUrl = Url::to(['get-permintaan']);
$script = <<< JS
$(document).on('change', '.select-permintaan', function() {
    var permintaanId = $(this).val();
    var row = $(this).closest('tr');
    var produkDropdown = row.find('.select-produk');
    var qtyInput = row.find('.input-qty');

    if (permintaanId) {
        $.ajax({
            url: '{$getPermintaanUrl}',
            type: 'GET',
            data: {id: permintaanId},
            success: function(data) {
                // Bersihkan dropdown produk
                produkDropdown.html('<option value="">Pilih Barang...</option>');
                
                if (data.items && data.items.length > 0) {
                    $.each(data.items, function(index, item) {
                        produkDropdown.append(
                            $('<option>', {
                                value: item.barang_id,
                                text: item.nama_barang,
                                'data-qty': item.qty // Simpan qty di sini
                            })
                        );
                    });

                    // Jika item cuma 1, langsung pilihkan otomatis
                    if (data.items.length === 1) {
                        produkDropdown.val(data.items[0].barang_id).trigger('change');
                    }
                }
            },
            error: function() {
                alert('Gagal mengambil data produk.');
            }
        });
    } else {
        produkDropdown.html('<option value="">Pilih Barang...</option>');
        qtyInput.val('');
    }
});

// Event ketika produk dipilih, Qty Plan otomatis terisi
$(document).on('change', '.select-produk', function() {
    var selected = $(this).find('option:selected');
    var qty = selected.data('qty');
    var row = $(this).closest('tr');
    
    if (qty !== undefined) {
        row.find('.input-qty').val(qty);
    } else {
        row.find('.input-qty').val('');
    }
});

function updateCapacity() {
    var totalMenitMps = 0;
    var startDate = $('#mps-tanggal_awal').val();
    var endDate = $('#mps-tanggal_akhir').val();

    // 1. Hitung total menit dari semua baris di dynamic form
    $('.item').each(function() {
        var qty = $(this).find('.input-qty').val() || 0;
        // Asumsi SMV rata-rata 25 menit (Nantinya bisa AJAX ke Master_Routing)
        totalMenitMps += (parseInt(qty) * 25); 
    });

    if (startDate && endDate) {
        // 2. Hitung Kapasitas Tersedia (Contoh Statis, bisa ambil dari Master)
        // Rumus: (10 Orang * 480 Menit * Jumlah Hari)
        var start = new Date(startDate);
        var end = new Date(endDate);
        var diffTime = Math.abs(end - start);
        var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
        
        var kapasitasTersedia = 10 * 480 * diffDays; // Misal 10 orang
        var persen = (totalMenitMps / kapasitasTersedia) * 100;

        // 3. Update Visual
        $('#bar-manpower').css('width', persen + '%').text(Math.round(persen) + '%');
        $('#text-manpower').text(totalMenitMps + " / " + kapasitasTersedia + " Menit");

        // Ganti warna jika overload
        if (persen > 100) {
            $('#bar-manpower').removeClass('bg-success').addClass('bg-danger');
            $('#alert-overload').show();
        } else {
            $('#bar-manpower').removeClass('bg-danger').addClass('bg-success');
            $('#alert-overload').hide();
        }
    }
}

// Jalankan fungsi saat ada perubahan input
$(document).on('change keyup', '.input-qty, #mps-tanggal_awal, #mps-tanggal_akhir', function() {
    updateCapacity();
});

// Jalankan saat baris dihapus
$(".dynamicform_wrapper").on("afterDelete", function(e) {
    updateCapacity();
});
JS;
$this->registerJs($script);
?>