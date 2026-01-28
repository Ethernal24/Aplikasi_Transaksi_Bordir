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

                <div class="col">
                    <?= $form->field($model, 'prioritas')->dropDownList([
                        0 => 'Low',
                        1 => 'Normal',
                        2 => 'High',
                        3 => 'Urgent',
                    ], [
                        'prompt' => 'Pilih Prioritas...'
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <?= $form->field($model, 'shift_id')->dropDownList(
                        ArrayHelper::map(Shift::find()->all(), 'shift_id', 'nama_shift'),
                        [
                            'prompt' => 'Pilih shift....',
                            'id' => 'mps-shift_id',
                        ]
                    )->label('Shift') ?>
                </div>
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
$getCapacityUrl = Url::to(['get-capacity']); // Pastikan route ini benar

$script = <<< JS
var capacityData = {};
var currentShiftDuration = 480
// 1. Ambil Kapasitas (Triggered by Header: Tanggal, Shift)
function fetchCapacity() {
    var start = $('#tgl_awal').val();
    var end = $('#tgl_akhir').val();
    var shiftId = $('#mps-shift_id').val();
    
    if (start && end && shiftId) {
        $.get('{$getCapacityUrl}', {start: start, end: end, shiftId: shiftId}, function(response) {
            capacityData = response.workcenters;
            currentShiftDuration = response.shift_duration || 480;
            renderWorkcenterBlocks(); // Buat box-box WC secara dinamis
            calculateCurrentLoad();
        });
    }
}

// 2. Render Box Workcenter secara dinamis ke UI
function renderWorkcenterBlocks() {
    var container = $('#workcenter-summary-container');
    container.empty();
    
    $.each(capacityData, function(id, wc) {
        // Tentukan apakah bagian mesin perlu dirender
        var machineHtml = '';
        if (wc.tipe_kapasitas == 0 || wc.tipe_kapasitas == 2) {
            machineHtml = `
                <div class="d-flex justify-content-between">
                    <label class="small mb-0">Mesin</label>
                    <small class="text-muted"><span id="val-mach-\${id}">0</span> / \${Math . round(wc . cap_machine) . toLocaleString('id-ID')}</small>
                </div>
                <div class="progress mb-2" style="height: 12px;">
                    <div id="bar-mach-\${id}" class="progress-bar bg-info" style="width:0%">0%</div>
                </div>`;
        }

        var block = `
            <div class="col-md-3 mb-3">
                <div class="card card-body shadow-sm border-left-info p-3">
                    <h6 class="font-weight-bold text-uppercase">\${wc . nama}</h6>
                    
                    <div class="d-flex justify-content-between">
                        <label class="small mb-0">Tenaga Kerja</label>
                        <small class="text-muted"><span id="val-man-\${id}">0</span> / \${Math . round(wc . cap_man) . toLocaleString('id-ID')}</small>
                    </div>
                    <div class="progress mb-2" style="height: 12px;">
                        <div id="bar-man-\${id}" class="progress-bar bg-success" style="width:0%">0%</div>
                    </div>

                    \${machineHtml} 

                    <div class="mt-2 text-right">
                        <small class="badge badge-light">Total Beban: <span id="text-wc-\${id}">0</span> Menit</small>
                    </div>
                </div>
            </div>`;
        
        container.append(block);
    });
}


// 3. Hitung Beban dari Detail MPS
function calculateCurrentLoad() {
    var wcLoads = {};
    var targetEff = parseFloat($('#mps-target_efisiensi').val()) || 100;
    var bufferTime = parseFloat($('#mps-buffer_time').val()) || 0;
    var multiplier = (1 / (targetEff / 100)) * (1 + (bufferTime / 100));

    $('.item:visible').each(function() {
        var qty = parseInt($(this).find('.input-qty').val()) || 0;
        var routingOption = $(this).find('.input-routing-id option:selected'); // Pastikan selector ke dropdown produk
        var details = routingOption.data('details'); 

        // Pengaman: Jika details berbentuk string, ubah jadi object
        if (typeof details === 'string') {
            details = JSON.parse(details);
        }

        if (details && Array.isArray(details)) {
            details.forEach(function(item) {
                // Gunakan wc_id dari routing detail
                if (!wcLoads[item.wc_id]) wcLoads[item.wc_id] = 0;
                
                // Rumus: Qty * SMV per Workcenter * Multiplier
                wcLoads[item.wc_id] += (qty * parseFloat(item.smv) * multiplier);
                
                // Opsional: Tambahkan setup menit (hanya sekali per batch)
                wcLoads[item.wc_id] += parseFloat(item.setup || 0);
            });
        }
    });

    // Update Progress Bar masing-masing Workcenter
    // Update Progress Bar & Angka masing-masing Workcenter
    $.each(capacityData, function(id, wc) {
        var load = wcLoads[id] || 0;
        var loadFormatted = Math.round(load).toLocaleString('id-ID');
        
        // 1. Logika Manpower (Selalu dihitung jika ada beban)
        var manPct = wc.cap_man > 0 ? (load / wc.cap_man * 100) : 0;
        updateBarVisual($('#bar-man-' + id), manPct);
        $('#val-man-' + id).text(loadFormatted);

        // 2. Logika Mesin (Hanya jika Workcenter memang menggunakan mesin)
        // Asumsi: Server mengirimkan properti 'use_machine' (boolean/int)
        if (wc.tipe_kapasitas == 2 || wc.cap_machine > 0 || wc.tipe_kapasitas == 0) {
            var machPct = wc.cap_machine > 0 ? (load / wc.cap_machine * 100) : 0;
            updateBarVisual($('#bar-mach-' + id), machPct);
            $('#val-mach-' + id).text(loadFormatted);
            
            // Pastikan container mesin tampil
            $('#bar-mach-' + id).parent().prev().show(); // Label 'Mesin'
            $('#bar-mach-' + id).parent().show();      // Progress bar mesin
        } else {
            // Jika tidak pakai mesin, sembunyikan UI mesin agar tidak membingungkan
            $('#bar-mach-' + id).parent().prev().hide();
            $('#bar-mach-' + id).parent().hide();
            $('#val-mach-' + id).text('-'); 
        }

        $('#text-wc-' + id).text(loadFormatted);
    });
    calculateEstimatedFinish(multiplier)
}

function updateBarVisual(el, pct) {
    el.css('width', (pct > 100 ? 100 : pct) + '%').text(Math.round(pct) + '%');
    el.removeClass('bg-success bg-warning bg-danger');
    if (pct > 100) el.addClass('bg-danger');
    else if (pct > 80) el.addClass('bg-warning');
    else el.addClass('bg-success');
}
function calculateEstimatedFinish(multiplier) {
    var startStr = $('#tgl_awal').val();
    if (!startStr) return;

    var startDate = new Date(startStr);
    var wcRunningMinutes = {}; 
    var dailyMinutes = currentShiftDuration; 

    $('.item:visible').each(function() {
        var row = $(this);
        var qty = parseInt(row.find('.input-qty').val()) || 0;
        var details = row.find('.input-routing-id option:selected').data('details');
        
        var maxCompletionMinutes = 0;

        if (details && qty > 0) {
            details.forEach(function(item) {
                // Rumus: (Qty * SMV * Multiplier) + Waktu Setup
                // Setup biasanya tidak dikalikan target efisiensi karena bersifat statis
                var totalTaskDuration = (qty * item.smv * multiplier) + item.setup;
                
                wcRunningMinutes[item.wc_id] = (wcRunningMinutes[item.wc_id] || 0) + totalTaskDuration;
                
                if (wcRunningMinutes[item.wc_id] > maxCompletionMinutes) {
                    maxCompletionMinutes = wcRunningMinutes[item.wc_id];
                }
            });

            var daysToAdd = Math.ceil(maxCompletionMinutes / dailyMinutes);
            var estimatedDate = addWorkDays(startDate, daysToAdd - 1);
            
            row.find('.est-finish-display').val(formatDate(estimatedDate));
        } else {
            row.find('.est-finish-display').val('-');
        }
    });
}

// Fungsi pembantu untuk format tanggal YYYY-MM-DD
function formatDate(date) {
    return date.toISOString().split('T')[0];
}

// Fungsi pembantu untuk menambah hari kerja (Melompati hari Minggu)
function addWorkDays(startDate, days) {
    var result = new Date(startDate);
    var added = 0;
    while (added < days) {
        result.setDate(result.getDate() + 1);
        if (result.getDay() !== 0) { // 0 adalah hari Minggu
            added++;
        }
    }
    return result;
}

// 3. AJAX Pilih Permintaan (Mengambil Produk & SMV)
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
                updateHeaderMaxDate()
                produkDropdown.html('<option value="">Pilih Barang...</option>');
                if (data.items && data.items.length > 0) {
                    $.each(data.items, function(index, item) {
                        produkDropdown.append(
                            $('<option>', {
                                value: item.barang_id,
                                text: item.nama_barang,
                                'data-qty': item.qty,
                                'data-smv': item.smv // PENTING: Pastikan Controller mengirim data smv
                            })
                        );
                    });

                    if (data.items.length === 1) {
                        produkDropdown.val(data.items[0].barang_id).trigger('change');
                    }
                }
            }
        });
    } else {
        produkDropdown.html('<option value="">Pilih Barang...</option>');
        qtyInput.val('');
        dueDateRef.val('');
        updateHeaderMaxDate();
        calculateCurrentLoad();
    }
});

function updateHeaderMaxDate() {
    var dates = [];
    // Ambil semua due date dari baris detail
    $('.input-due-date-ref').each(function() {
        var val = $(this).val();
        if (val) dates.push(new Date(val));
    });

    if (dates.length > 0) {
        // Cari tanggal paling awal (deadline paling mepet)
        var minDate = new Date(Math.min.apply(null, dates));
        var formatted = minDate.toISOString().split('T')[0];
        
        // Target element Header
        var headerStart = $('#tgl_awal'); // Sesuaikan ID field tanggal awal header Anda
        var headerEnd = $('#tgl_akhir');   // Sesuaikan ID field tanggal akhir header Anda

        // 1. Set atribut MAX agar kalender mengunci tanggal setelah deadline
        headerStart.attr('max', formatted);
        headerEnd.attr('max', formatted);
        
        // 2. Validasi: Jika Tanggal AWAL Header melampaui deadline
        if (headerStart.val() && headerStart.val() > formatted) {
            headerStart.val(formatted);
            alert('Tanggal AWAL Header disesuaikan ke ' + formatted + ' karena tidak boleh melebihi deadline SO.');
        }

        // 3. Validasi: Jika Tanggal AKHIR Header melampaui deadline
        if (headerEnd.val() && headerEnd.val() > formatted) {
            headerEnd.val(formatted);
            alert('Tanggal AKHIR Header disesuaikan ke ' + formatted + ' karena tidak boleh melebihi deadline SO.');
        }
    }
}
$(document).on('click', '.remove-item', function() {
    // Beri jeda sedikit agar baris benar-benar hilang dari DOM sebelum hitung ulang
    setTimeout(function() {
        updateHeaderMaxDate();
    }, 100);
});

// 4. Event Listener saat Produk dipilih (untuk update Qty & Hitung Beban)
$(document).on('change', '.select-produk', function() {
    var selected = $(this).find('option:selected');
    var qty = selected.data('qty');
    var row = $(this).closest('tr');
    var produkId = $(this).val();
    
    var routingDropdown = row.find('.input-routing-id');
    var hiddenRouting = row.find('.hidden-routing-id'); // Tambahkan selector ini

    if (produkId) {
        // Mencari option yang memiliki data-produk yang sesuai
        var matchedOption = routingDropdown.find('option[data-produk="' + produkId + '"]');
        var matchedValue = matchedOption.val();
        
        if (matchedValue) {
            routingDropdown.val(matchedValue).trigger('change');
            hiddenRouting.val(matchedValue); // Isi hidden input untuk dikirim ke server
        } else {
            routingDropdown.val('').trigger('change');
            hiddenRouting.val('');
        }
    } else {
        routingDropdown.val('').trigger('change');
        hiddenRouting.val('');
    }
    
    if (qty !== undefined) {
        row.find('.input-qty').val(qty);
    }

    calculateCurrentLoad(); // Hitung ulang saat produk (SMV) berubah
});



// 5. Listener untuk Input Manual & Tanggal
// Listener yang memicu FETCH (Ambil data dari server karena "Tangki" Kapasitas berubah)
$(document).on('change', '#tgl_awal, #tgl_akhir, #mps-shift_id', fetchCapacity);

// Listener yang memicu REKALKULASI (Hitung beban karena "Isi" atau "Pengali" berubah)
$(document).on('change keyup', '#mps-target_efisiensi, #mps-buffer_time, .input-routing-id, .input-qty', calculateCurrentLoad);$(document).on('keyup change', '.input-qty', calculateCurrentLoad);
// 6. Listener untuk Dynamic Form (Tambah/Hapus Baris)
$(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    calculateCurrentLoad();
});

$(".dynamicform_wrapper").on("afterDelete", function(e) {
    calculateCurrentLoad();
});

$(document).ready(function(){
    // Saat tanggal awal berubah
    $('#tgl_awal').change(function(){
        var selectedDate = $(this).val();
        
        // Set minimal tanggal akhir sama dengan tanggal awal
        $('#tgl_akhir').attr('min', selectedDate);
        
        // Jika tanggal akhir sudah terisi dan ternyata lebih kecil dari tanggal awal yang baru, kosongkan
        var tglAkhir = $('#tgl_akhir').val();
        if(tglAkhir && tglAkhir < selectedDate){
            $('#tgl_akhir').val(selectedDate);
        }
    });
});

// Jalankan kapasitas saat load pertama kali (untuk mode Update)
fetchCapacity();
JS;
$this->registerJs($script);
?>