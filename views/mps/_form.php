<?php

use app\models\Barang;
use app\models\MasterMrp;
use app\models\MasterRouting;
use app\models\Mps;
use app\models\PermintaanPelanggan;
use app\models\Shift;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;
use yii\helpers\Json;

/** @var yii\web\View $this */
/** @var app\models\Mps $model */
/** @var yii\widgets\ActiveForm $form */


// Ambil semua routing beserta detailnya (eager loading untuk performa)
$allRouting = MasterRouting::find()->with('details')->all();

$routingOptions = [];
foreach ($allRouting as $routing) {
    $details = [];
    // routingDetails adalah relasi ke tabel Master_Routing_Detail
    foreach ($routing->details as $d) {
        $details[] = [
            'wc_id' => $d->workcenter_id,
            'smv' => $d->standard_time_menit,
            'setup' => $d->waktu_setup_menit
        ];
    }

    // Simpan ke dalam format yang dipahami DropDownList Yii2
    $routingOptions[$routing->routing_id] = [
        'data-details' => Json::encode($details),
        'data-produk' => $routing->produk_id
    ];
}

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
                    <?= $form->field($model, 'periode')->textInput([
                        'type' => 'date',
                        'min' => date('Y-m-d'),

                    ]) ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'kode_mps')->textInput(['readonly' => true]) ?>
                </div>

                <div class="col">
                    <?= $form->field($model, 'tanggal_awal')->textInput([
                        'type' => 'date',
                        'id' => 'tgl_awal',
                        'min' => date('Y-m-d'),
                    ]) ?>
                </div>

                <div class="col">
                    <?= $form->field($model, 'tanggal_akhir')->textInput([
                        'type' => 'date',
                        'id' => 'tgl_akhir',
                    ]) ?>
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

                <!-- <div class="col">
                    <?= $form->field($model, 'prioritas')->dropDownList([
                        0 => 'Low',
                        1 => 'Normal',
                        2 => 'High',
                        3 => 'Urgent',
                    ], [
                        'prompt' => 'Pilih Prioritas...'
                    ]) ?>
                </div> -->
            </div>
            <div class="row">
                <!-- <div class="col">
                    <?= $form->field($model, 'shift_id')->dropDownList(
                        ArrayHelper::map(Shift::find()->all(), 'shift_id', 'nama_shift'),
                        [
                            'prompt' => 'Pilih shift....',
                            'id' => 'mps-shift_id',
                        ]
                    )->label('Shift') ?>
                </div> -->
                <div class="col">
                    <?= $form->field($model, 'buffer_time')->textInput() ?>
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
                        <th>Kode Permintaan</th>
                        <th>Nama Produk</th>
                        <th>Rute Produk</th>
                        <th>Qty plan</th>
                        <th>Tenggat Waktu</th>
                        <th>Estimasi Selesai</th>
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
                                <?= $form->field($detail, "[{$i}]routing_id", ['template' => "{input}\n{error}"])
                                    ->dropDownList(
                                        ArrayHelper::map(
                                            MasterRouting::find()->all(),
                                            'routing_id',
                                            'nama_routing'
                                        ),
                                        [
                                            'prompt' => 'Pilih Routing...',
                                            'class' => 'form-control input-routing-id',
                                            'disabled' => true,
                                            'options' => $routingOptions
                                        ]
                                    ) // Tambahkan class ini 
                                ?>
                                <?= Html::activeHiddenInput($detail, "[{$i}]routing_id", ['class' => 'hidden-routing-id']) ?>
                            </td>
                            <td>
                                <?= $form->field($detail, "[{$i}]qty_plan", ['template' => "{input}\n{error}"])
                                    ->textInput(['class' => 'form-control input-qty', 'readonly' => true]) // Tambahkan class ini 
                                ?>
                            </td>
                            <td>
                                <?php
                                // Logika untuk menampilkan data saat mode Update (data sudah tersimpan di DB)
                                $dueDateVal = '';
                                if (!$detail->isNewRecord && $detail->permintaan) {
                                    $dueDateVal = $detail->permintaan->tenggat_waktu;
                                }

                                echo Html::textInput("due_date_ref[{$i}]", $dueDateVal, [
                                    'class' => 'form-control input-due-date-ref',
                                    'readonly' => true,
                                    'placeholder' => '-'
                                ]);
                                ?>
                            </td>
                            <td>
                                <?= $form->field($detail, "[{$i}]estimasi_selesai", ['template' => "{input}\n{error}"])
                                    ->textInput(['class' => 'form-control est-finish-display', 'readonly' => true]) // Tambahkan class ini 
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
            <!-- <div>
                <h4>Ringkasan Beban Produksi (Per Workcenter)</h4>
                <hr>
                <div id="workcenter-summary-container" class="row">
                    <div class="col-12 text-center text-muted">
                        <p>Pilih Tanggal dan Shift untuk melihat kapasitas...</p>
                    </div>
                </div>

                <div id="alert-overload" class="alert alert-danger mt-3" style="display:none;">
                    <strong>Peringatan!</strong> Salah satu Workcenter melebihi kapasitas (Bottleneck).
                    Silakan sesuaikan jadwal, efisiensi, atau total pekerja.
                </div>
            </div> -->
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Back', Yii::$app->request->referrer ?: ['index'], [
                    'class' => 'btn btn-secondary'
                ]) ?> </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<?php
$getPermintaanUrl = Url::to(['get-permintaan']);

$script = <<< JS

async function hitungSemuaBaris(){
    let tglMulaiHeader = $('#tgl_awal').val();
    if(!tglMulaiHeader) return;

    let currentStartDate = tglMulaiHeader;
    let rows = $('.container-items .item');
    
    for (let i = 0; i < rows.length; i++) {
        let row = $(rows[i]);
        // Tunggu hasil estimasi baris saat ini
        let tglSelesai = await hitungEstimasi(row, currentStartDate);
        
        if (tglSelesai) {
            // Baris berikutnya mulai H+1 setelah baris ini selesai
            currentStartDate = tambahHari(tglSelesai, 1);
        }
    }
 
}


// 1. Ambil Kapasitas (Triggered by Header: Tanggal, Shift)
function hitungEstimasi(row, tanggalMulai){
    return new Promise((resolve)=>{
        let routingId = row.find('.input-routing-id').val();
        let qty = row.find('.input-qty').val();
        console.log("Mencoba hitung: ", {routingId, qty, tanggalMulai})
    
        if(routingId && qty && tanggalMulai){
            $.ajax({
                url:'/mps/ajax-hitung-estimasi',
                type:'GET',
                dataType: 'json',
                data: {
                    routing_id:routingId,
                    qty:qty,
                    tanggal_awal:tanggalMulai,
                },
                success: function (response){
                    if (response.status == 'success') {
                        let estimasi = response.estimasi_selesai;
                        let deadline = row.find('.input-due-date-ref').val();
                        let inputEstimasi = row.find('input[id$="-estimasi_selesai"]');
    
                        inputEstimasi.val(estimasi);
    
                        // Jika estimasi melewati deadline, beri warna merah
                        if (deadline && estimasi > deadline) {
                            inputEstimasi.css({'background-color': '#ffcccc', 'color': 'red', 'font-weight': 'bold'});
                            // Opsional: Tampilkan pesan peringatan
                            alert('Peringatan: Estimasi selesai melebihi tenggat waktu pelanggan!');
                        } else {
                            inputEstimasi.css({'background-color': '#ccffcc', 'color': 'green', 'font-weight': 'bold'});
                        }
                        resolve(estimasi);
                    }else{
                        resolve(null);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Gagal hitung di baris ini")
                    resolve(null);
                    console.error("AJAX Error Terdeteksi:");
                    console.error("Status: " + status);
                    console.error("Error: " + error);
                    console.log("Response Text: " + xhr.responseText);
                }
            })
        }else{
            resolve(null);
        }
    });
}

// Fungsi pembantu tambah hari
function tambahHari(dateStr, days) {
    let result = new Date(dateStr);
    result.setDate(result.getDate() + days);
    return result.toISOString().split('T')[0];
}


// 2. Pilih Permintaan (SO)
$(document).on('change', '.select-permintaan', function() {
    var permintaanId = $(this).val();
    var row = $(this).closest('tr');
    var produkDropdown = row.find('.select-produk');
    var qtyInput = row.find('.input-qty');
    var dueDateRef = row.find('.input-due-date-ref');

    if (permintaanId) {
        $.ajax({
            url: '{$getPermintaanUrl}',
            type: 'GET',
            data: {id: permintaanId},
            success: function(data) {
                dueDateRef.val(data.due_date);
                updateHeaderMaxDate();
                produkDropdown.html('<option value="">Pilih Barang...</option>');
                $.each(data.items, function(index, item) {
                    produkDropdown.append($('<option>', {
                        value: item.barang_id,
                        text: item.nama_barang,
                        'data-qty': item.qty
                    }));
                });

                if (data.items.length === 1) {
                    produkDropdown.val(data.items[0].barang_id).trigger('change');
                }
            }
        });
    }
});

// 3. Pilih Produk -> Otomatis cari Routing & Hitung Estimasi
$(document).on('change', '.select-produk', function() {
    var selected = $(this).find('option:selected');
    var qty = selected.data('qty');
    var row = $(this).closest('tr');
    var produkId = $(this).val();
    
    var routingDropdown = row.find('.input-routing-id');
    var hiddenRouting = row.find('.hidden-routing-id');

    if (produkId) {
        var matchedOption = routingDropdown.find('option[data-produk="' + produkId + '"]');
        var matchedValue = matchedOption.val();
        
        if (matchedValue) {
            routingDropdown.val(matchedValue).trigger('change');
            hiddenRouting.val(matchedValue);
        }
    }
    
    if (qty !== undefined) {
        row.find('.input-qty').val(qty);
    }

    hitungSemuaBaris(); 
});

// 4. Update Batasan Tanggal (Deadline SO)
function updateHeaderMaxDate() {
    var dates = [];
    $('.input-due-date-ref').each(function() {
        var val = $(this).val();
        if (val) dates.push(new Date(val));
    });

    if (dates.length > 0) {
        var minDate = new Date(Math.min.apply(null, dates));
        var formatted = minDate.toISOString().split('T')[0];
        
        $('#tgl_awal, #tgl_akhir').attr('max', formatted);

        if ($('#tgl_awal').val() > formatted) $('#tgl_awal').val(formatted);
        if ($('#tgl_akhir').val() > formatted) $('#tgl_akhir').val(formatted);
    }
}

// 5. Trigger hitung ulang saat input berubah
$(document).on('change keyup', '.input-qty, #tgl_awal', function() {
    var row = $(this).closest('tr');
    if (row.length) {
        hitungSemuaBaris();
    } else {
        // Jika tgl_awal yang berubah, hitung ulang semua baris
        $('.dynamicform_wrapper tr').each(function() {
            hitungSemuaBaris();
        });
    }
});

// 6. Validasi Tanggal Range
$('#tgl_awal').change(function(){
    var selectedDate = $(this).val();
    $('#tgl_akhir').attr('min', selectedDate);
    if($('#tgl_akhir').val() < selectedDate) $('#tgl_akhir').val(selectedDate);
});

$(document).on('click', '.remove-item', function() {
    setTimeout(function() {
        console.log("Baris dihapus, menghitung ulang jadwal...");
        updateHeaderMaxDate();
        hitungSemuaBaris(); 
    }, 100);
});
JS;
$this->registerJs($script);
?>