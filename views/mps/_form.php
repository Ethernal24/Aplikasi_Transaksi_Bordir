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
        'data-details' => Json::encode($details)
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
                    <?= $form->field($model, 'periode')->textInput(['type' => 'date']) ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'kode_mps')->textInput(['readonly' => true]) ?>
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
                    ) ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'buffer_time')->textInput() ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'target_efisiensi')->textInput() ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'total_pekerja')->textInput() ?>
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
                        <th>Routing ID</th>
                        <th>Qty plan</th>
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
                                            'options' => $routingOptions
                                        ]
                                    ) // Tambahkan class ini 
                                ?>
                            </td>
                            <td>
                                <?= $form->field($detail, "[{$i}]qty_plan", ['template' => "{input}\n{error}"])
                                    ->textInput(['class' => 'form-control input-qty', 'readonly' => true]) // Tambahkan class ini 
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
            <div>
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
            </div>
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

// 1. Ambil Kapasitas (Triggered by Header: Tanggal, Shift)
function fetchCapacity() {
    var start = $('#mps-tanggal_awal').val();
    var end = $('#mps-tanggal_akhir').val();
    var shiftId = $('#mps-shift_id').val();
    
    if (start && end && shiftId) {
        $.get('{$getCapacityUrl}', {start: start, end: end, shiftId: shiftId}, function(data) {
            capacityData = data;
            renderWorkcenterBlocks(); // Buat box-box WC secara dinamis
            calculateCurrentLoad();
        });
    }
}

// 2. Render Box Workcenter secara dinamis ke UI
function renderWorkcenterBlocks() {
    var container = $('#workcenter-summary-container');
    container.empty();
    
    if ($.isEmptyObject(capacityData)) {
        container.append('<div class="col-12 text-center text-muted"><p>Data kapasitas tidak tersedia.</p></div>');
        return;
    }

    $.each(capacityData, function(id, wc) {
        // Format angka dengan toLocaleString() agar ada pemisah ribuan (1.000)
        var capManFormatted = Math.round(wc.cap_man).toLocaleString('id-ID');
        var capMachFormatted = Math.round(wc.cap_machine).toLocaleString('id-ID');

        var block = '<div class="col-md-4 mb-3">' +
            '<div class="card card-body shadow-sm border-left-info">' +
                '<h6 class="font-weight-bold text-uppercase">' + wc.nama + '</h6>' +
                
                // Info Tenaga Kerja
                '<div class="d-flex justify-content-between">' +
                    '<label class="small mb-0">Tenaga Kerja</label>' +
                    '<small class="text-muted"><span id="val-man-' + id + '">0</span> / ' + capManFormatted + '</small>' +
                '</div>' +
                '<div class="progress mb-2" style="height: 12px;">' +
                    '<div id="bar-man-' + id + '" class="progress-bar bg-success" style="width:0%">0%</div>' +
                '</div>' +
                
                // Info Mesin
                '<div class="d-flex justify-content-between">' +
                    '<label class="small mb-0">Mesin</label>' +
                    '<small class="text-muted"><span id="val-mach-' + id + '">0</span> / ' + capMachFormatted + '</small>' +
                '</div>' +
                '<div class="progress mb-2" style="height: 12px;">' +
                    '<div id="bar-mach-' + id + '" class="progress-bar bg-info" style="width:0%">0%</div>' +
                '</div>' +
                
                '<div class="mt-2 text-right">' +
                    '<small class="badge badge-light">Total Beban: <span id="text-wc-' + id + '">0</span> Menit</small>' +
                '</div>' +
            '</div>' +
        '</div>';
        
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
        var routingOption = $(this).find('.input-routing-id option:selected');
        var details = routingOption.data('details'); // Mengambil data-details JSON

        if (details) {
            details.forEach(function(item) {
                if (!wcLoads[item.wc_id]) wcLoads[item.wc_id] = 0;
                wcLoads[item.wc_id] += (qty * item.smv * multiplier);
            });
        }
    });

    // Update Progress Bar masing-masing Workcenter
    // Update Progress Bar & Angka masing-masing Workcenter
    $.each(capacityData, function(id, wc) {
        var load = wcLoads[id] || 0;
        var loadFormatted = Math.round(load).toLocaleString('id-ID');
        
        var manPct = wc.cap_man > 0 ? (load / wc.cap_man * 100) : 0;
        var machPct = wc.cap_machine > 0 ? (load / wc.cap_machine * 100) : 0;

        // Update Visual Bar
        updateBarVisual($('#bar-man-' + id), manPct);
        updateBarVisual($('#bar-mach-' + id), machPct);
        
        // UPDATE ANGKA REALTIME
        $('#val-man-' + id).text(loadFormatted); // Angka beban di baris Tenaga Kerja
        $('#val-mach-' + id).text(loadFormatted); // Angka beban di baris Mesin
        $('#text-wc-' + id).text(loadFormatted); // Angka total di badge bawah
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
    var startStr = $('#mps-tanggal_awal').val();
    if (!startStr) return;

    var startDate = new Date(startStr);
    var wcRunningMinutes = {}; 
    var dailyMinutes = 480; 

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

    if (permintaanId) {
        $.ajax({
            url: '{$getPermintaanUrl}',
            type: 'GET',
            data: {id: permintaanId},
            success: function(data) {
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
        calculateCurrentLoad();
    }
});

// 4. Event Listener saat Produk dipilih (untuk update Qty & Hitung Beban)
$(document).on('change', '.select-produk', function() {
    var selected = $(this).find('option:selected');
    var qty = selected.data('qty');
    var row = $(this).closest('tr');
    
    if (qty !== undefined) {
        row.find('.input-qty').val(qty);
    }
    calculateCurrentLoad(); // Hitung ulang saat produk (SMV) berubah
});

// 5. Listener untuk Input Manual & Tanggal
// Listener yang memicu FETCH (Ambil data dari server karena "Tangki" Kapasitas berubah)
$(document).on('change', '#mps-tanggal_awal, #mps-tanggal_akhir, #mps-shift_id', fetchCapacity);
$(document).on('keyup change', '#mps-total_pekerja', fetchCapacity);

// Listener yang memicu REKALKULASI (Hitung beban karena "Isi" atau "Pengali" berubah)
$(document).on('change keyup', '#mps-target_efisiensi, #mps-buffer_time, .input-routing-id, .input-qty', calculateCurrentLoad);$(document).on('keyup change', '.input-qty', calculateCurrentLoad);
// 6. Listener untuk Dynamic Form (Tambah/Hapus Baris)
$(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    calculateCurrentLoad();
});

$(".dynamicform_wrapper").on("afterDelete", function(e) {
    calculateCurrentLoad();
});

// Jalankan kapasitas saat load pertama kali (untuk mode Update)
fetchCapacity();
JS;
$this->registerJs($script);
?>