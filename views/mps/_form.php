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


            </div>
            <div class="row">
                <div class="col">
                    <?= $form->field($model, 'buffer_time')->textInput() ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'alokasi_mesin')->textInput() ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'alokasi_karyawan')->textInput() ?>
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
                                <!-- <small>
                                    <a href="javascript:void(0)" class="btn-setup-mesin" data-index="<?= $i ?>">
                                        <i class="fa fa-cogs"></i> Atur Alokasi Mesin
                                    </a>
                                </small> -->
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
            <div id="card-container" class="row mt-3">
                <h4>Ringkasan Beban</h4>
                <div class="col-12 text-muted">
                    <p>Silakan isi Qty dan Pilih Routing untuk melihat analisa beban kerja.</p>
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

$script = <<< JS

async function hitungSemuaBaris(){
    let tglMulaiHeader = $('#tgl_awal').val();
    if(!tglMulaiHeader) return;

    let currentStartDate = tglMulaiHeader;
    let rows = $('.container-items .item');
    
    for (let i = 0; i < rows.length; i++) {
        let row = $(rows[i]);
        // Ambil estimasi dari API agar perhitungan Workcenter & Shift akurat
        let tglSelesai = await hitungEstimasi(row, currentStartDate);
        
        if (tglSelesai) {
            // Baris berikutnya mulai H+1 (asumsi satu line produksi serial)
            // Jika konveksi Anda bisa paralel, ganti logika ini
            currentStartDate = tambahHari(tglSelesai, 1);
        }
    }
    updateKapasitasTotal();
}


// 1. Ambil Kapasitas (Triggered by Header: Tanggal, Shift)
function hitungEstimasi(row, tanggalMulai){
    return new Promise((resolve)=>{
        let routingId = row.find('.input-routing-id').val();
        let qty = row.find('.input-qty').val();
        console.log("Mencoba hitung: ", {routingId, qty, tanggalMulai})
    
        if(routingId && qty && tanggalMulai){
            $.ajax({
                url:'/api/hitung-estimasi',
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
function updateKapasitasTotal() {
    let items = [];
    let tglMulai = $('#tgl_awal').val(); 
    let tglAkhir = $('#tgl_akhir').val(); 

    $('.container-items .item').each(function() { // Perbaikan selector ke .item
        let rId = $(this).find('.input-routing-id').val();
        let q = $(this).find('.input-qty').val();
        if (rId && q) {
            items.push({ routing_id: rId, qty: q });
        }
    });

    if (items.length > 0 && tglMulai && tglAkhir) {
        $.ajax({
            url: '/api/hitung-kapasitas-total',
            type: 'POST',
            data: { 
                items: items, 
                tgl_mulai: tglMulai, 
                tgl_akhir: tglAkhir 
            },
            success: function(res) {
                if(res.status === 'success'){
                    $('#card-container').html(res.html_cards);
                }            
            }
        });
    }
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

$('#tgl_akhir').on('change', function() {
    updateKapasitasTotal();
});

$(document).on('click', '.remove-item', function() {
    setTimeout(function() {
        console.log("Baris dihapus, menghitung ulang jadwal...");
        updateHeaderMaxDate();
        hitungSemuaBaris(); 
    }, 100);
});

$(document).on('click', '.btn-setup-mesin', function() {
    var index = $(this).data('index');
    // Pastikan ID selector ini sesuai dengan yang ada di <tr> detail alokasi
    $('#allocation-' + index).slideToggle(); 
    
    // Ambil data rute dari dropdown
    var routingId = $('select[name="MpsDetail[' + index + '][routing_id]"]').val();
    
    if(routingId) {
        // SESUAIKAN NAMA FUNGSI: loadAllocationDetails
        loadAllocationDetails(index, routingId);
    } else {
        alert("Silakan pilih Rute Produk terlebih dahulu.");
    }
});

function loadAllocationDetails(index, routingId) {
    // Pastikan ID selector ini sama dengan yang ada di elemen HTML pembungkus
    var containers = $('#allocation-content-' + index); 
    
    // Cek apakah containers ditemukan agar tidak error undefined
    if (containers.length === 0) {
        console.error("Elemen #allocation-content-" + index + " tidak ditemukan!");
        return;
    }

    // Cegah load berulang jika tabel sudah dirender
    if (containers.find('table').length > 0) return;

    containers.html('<i class="fa fa-spinner fa-spin"></i> Memuat tahapan rute...');

    $.ajax({
        url: 'get-routing-details', // Pastikan URL ini sesuai dengan routing di Controller Anda
        type: 'GET',
        data: { routing_id: routingId },
        success: function(data) {
            var html = '<table class="table table-condensed table-bordered" style="background: white; margin-bottom: 0;">' +
                       '<thead class="bg-blue" style="color: white;"><tr>' +
                       '<th>Tahapan (Workcenter)</th>' +
                       '<th>Waktu Setup (Min)</th>' +
                       '<th>Standard Time (Min)</th>' +
                       '<th style="width: 150px;">Jumlah Mesin</th>' +
                       '</tr></thead><tbody>';
            
            if (data.length > 0) {
                $.each(data, function(i, item) {
                    html += '<tr>' +
                            '<td>' + item.nama_workcenter + '</td>' +
                            '<td>' + item.waktu_setup_menit + '</td>' +
                            '<td>' + item.std_time + '</td>' +
                            '<td><input type="number" name="MpsDetail['+index+'][allocation]['+item.workcenter_id+']" ' +
                            'class="form-control input-sm input-mesin" value="1" min="1"></td>' +
                            '</tr>';
                });
            } else {
                html += '<tr><td colspan="3" class="text-center">Tidak ada detail tahapan untuk rute ini.</td></tr>';
            }
            
            html += '</tbody></table>';
            containers.html(html);
        },
        error: function() {
            containers.html('<span class="text-danger">Gagal mengambil data tahapan.</span>');
        }
    });
}
// Listener ketika jumlah mesin diubah
$(document).on('input', '.input-mesin', function() {
    var row = $(this).closest('.allocation-detail-row');
    var index = row.attr('id').split('-')[1]; // Ambil index dari id allocation-0, allocation-1
    
    hitungUlangEstimasi(index);
});

function hitungUlangEstimasi(index) {
    var totalWaktu = 0;
    var qtyPlan = parseFloat($('input[name="MpsDetail[' + index + '][qty_plan]"]').val()) || 0;
    var menitPerHari = 900; 

    // 1. Ambil Tanggal Mulai (Harus teliti di sini)
    var tanggalMulai;
    if (index == 0) {
        tanggalMulai = $('#tgl_awal').val();
    } else {
        var prevIndex = index - 1;
        tanggalMulai = $('input[name="MpsDetail[' + prevIndex + '][estimasi_selesai]"]').val();
    }

    if (!tanggalMulai || tanggalMulai === "-") return;

    // 2. Hitung total menit dari tabel alokasi
    var rowsAlokasi = $('#allocation-content-' + index + ' tbody tr');
    
    if (rowsAlokasi.length > 0) {
        rowsAlokasi.each(function() {
            var setupTime = parseFloat($(this).find('td:eq(1)').text()) || 0; 
            var stdTime = parseFloat($(this).find('td:eq(2)').text()) || 0; 
            var qtyMesin = parseFloat($(this).find('.input-mesin').val()) || 1;
            
            totalWaktu += setupTime + ((stdTime * qtyPlan) / qtyMesin);
        });
    } else {
        // FALLBACK: Jika tabel alokasi belum dibuka/dimuat, 
        // jangan set totalWaktu ke 0, tapi ambil nilai lama atau hitung standar (mesin=1)
        // Ini penyebab tanggal baris 2 jadi ngaco (loncat ke tanggal yg sama)
        return; 
    }

    // 3. Update Tanggal Selesai
    var displayEst = $('input[name="MpsDetail[' + index + '][estimasi_selesai]"]');
    var tglSelesai = formatMenitKeTanggal(totalWaktu, tanggalMulai, menitPerHari);
    displayEst.val(tglSelesai);

    // 4. Update Log Info
    var hariNeeded = Math.ceil(totalWaktu / menitPerHari);
    var infoHtml = `<small class="text-muted">Beban: \${totalWaktu . toFixed(1)} m | Butuh: \${hariNeeded} Hari</small>`;
    $('#allocation-content-' + index).find('.info-beban').remove();
    $('#allocation-content-' + index).append(`<div class="info-beban text-right">\${infoHtml}</div>`);

    // 5. Teruskan ke baris bawahnya
    updateEfekDomino(index); 
}

function formatMenitKeTanggal(totalWaktu, baseDate, menitPerHari) {
    if (isNaN(totalWaktu) || totalWaktu <= 0 || !baseDate) return "-";

    // 1. Hitung berapa hari yang dibutuhkan berdasarkan kapasitas konveksi (misal 900 menit/hari)
    // Kita kurangi 1 karena hari pertama dihitung sebagai hari kerja pertama
    let hariNeeded = Math.ceil(totalWaktu / menitPerHari);
    let tambahanHari = hariNeeded > 0 ? hariNeeded - 1 : 0;

    // 2. Olah tanggal
    let safeDateStr = baseDate.replace(/-/g, "/");
    let date = new Date(safeDateStr);
    date.setHours(0, 0, 0, 0);

    // 3. Tambahkan hari, bukan menit
    date.setDate(date.getDate() + hariNeeded);

    let year = date.getFullYear();
    let month = ("0" + (date.getMonth() + 1)).slice(-2);
    let day = ("0" + date.getDate()).slice(-2);

    return year + "-" + month + "-" + day;
}

function updateEfekDomino(currentIndex) {
    let nextIndex = parseInt(currentIndex) + 1;
    let nextRow = $('input[name="MpsDetail[' + nextIndex + '][qty_plan]"]');

    // Jika baris berikutnya ada di form
    if (nextRow.length > 0) {
        console.log("Memicu hitung ulang untuk baris: " + nextIndex);
        
        // Panggil fungsi hitung untuk baris selanjutnya
        // Ini akan menciptakan rantai otomatis sampai baris terakhir
        hitungUlangEstimasi(nextIndex);
    }
}
JS;
$this->registerJs($script);
?>