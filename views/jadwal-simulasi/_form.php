<?php

use app\models\Barang;
use app\models\MasterPelanggan;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\JadwalSimulasi $model */
/** @var yii\widgets\ActiveForm $form */
// echo "<pre>";
// print_r($disabledDates);
// echo "</pre>";
?>
<style>
    /* Membuat tanggal yang disabled berwarna merah pudar dan dicoret */
    .datepicker table tr td.disabled,
    .datepicker table tr td.disabled:hover {
        color: #ff0000 !important;
        text-decoration: line-through;
        background-color: #f8f9fa !important;
        cursor: not-allowed !important;
    }
</style>
<div class="pc-content">
    <div class="card table-card">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="card-body mx-4">
            <?php $form = ActiveForm::begin(); ?>
            <div class="row">
                <div class="col">
                    <?= $form->field($model, 'produk_id')->widget(Select2::class, [
                        'options' => [
                            'placeholder' => 'pilih Produk...',
                        ],
                        'data' => ArrayHelper::map(Barang::find()
                            ->asArray()
                            ->where(['tipe_barang' => 2])
                            ->all(), 'barang_id', 'nama_barang'),
                    ]) ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'pelanggan_id')->widget(Select2::class, [
                        'options' => [
                            'placeholder' => 'Pilih Pelanggan...',
                        ],
                        'data' => ArrayHelper::map(MasterPelanggan::find()->all(), 'pelanggan_id', 'nama_pelanggan')
                    ]) ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'quantity')->textInput() ?>
                </div>
                <div class="row">
                    <div class="col">
                        <?= $form->field($model, 'tanggal_mulai')->widget(DatePicker::class, [
                            'options' => [
                                'placeholder' => 'Pilih tanggal...',
                                'autocomplete' => 'off', // Tambahkan ini agar tidak tertutup history browser
                            ],
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd',
                                'todayHighlight' => true,
                                // Gunakan variabel $workorder yang dikirim dari controller
                                'datesDisabled' => $disabledDates,
                                // Tambahkan startDate agar tanggal sebelum hari ini otomatis mati
                                'startDate' => date('Y-m-d'),
                            ],
                        ]) ?>
                    </div>
                    <div class="col">
                        <?= $form->field($model, 'dateline')->widget(DatePicker::class, [
                            'options' => [
                                'placeholder' => 'Pilih Tanggal Dateline...',
                                'autocomplete' => 'off',
                            ],
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd',
                                'todayHighlight' => true,
                                'datesDisabled' => $disabledDates,
                                // Tambahkan startDate agar tanggal sebelum hari ini otomatis mati
                                'startDate' => date('Y-m-d'),
                            ],
                        ]) ?>
                    </div>
                    <div class="col">
                        <?= $form->field($model, 'estimasi_selesai')->textInput() ?>
                    </div>
                </div>
                <hr>
                <div class="card mx-2">
                    <h4>Ringkasan Kebutuhan hari</h4>
                </div>


                <div class="form-group">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                    <?= Html::a('Back', 'index', ['class' => 'btn btn-secondary']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<?php
$urlHitungEstimasi = Url::to('/api/hitung-estimasi');
$urlHitungQuantity = Url::to('/api/hitung-quantity');
$script = <<<JS
    function hitungEstimasi(){
        let qty = $('#jadwalsimulasi-quantity').val();
        let produk = $('#jadwalsimulasi-produk_id').val();
        let tanggal = $('#jadwalsimulasi-tanggal_mulai').val();
        
        if (produk && qty && tanggal) {
            $.ajax({
                url: '$urlHitungEstimasi',
                type: 'GET',
                data: { produk_id: produk, qty: qty, tanggal_awal: tanggal },
                success: function(res) {
                    if (res.status === 'success') {
                        // Matikan dulu listener agar tidak loop
                        $('#jadwalsimulasi-dateline, #jadwalsimulasi-estimasi_selesai').off('change');
                        
                        $('#jadwalsimulasi-dateline').val(res.estimasi_selesai).trigger('change.datepicker');
                        $('#jadwalsimulasi-estimasi_selesai').val(res.durasi);
                        
                        // Hidupkan kembali listener setelah pengisian selesai
                        rebindEvents();
                    }
                }
            });
        }
    }

    // 2. Fungsi Hitung Qty (dari Dateline atau Durasi)
    function hitungQtyOtomatis(){
        let tglSelesai = $('#jadwalsimulasi-dateline').val();
        let produk = $('#jadwalsimulasi-produk_id').val();
        let tglMulai = $('#jadwalsimulasi-tanggal_mulai').val();
        
        if (produk && tglSelesai && tglMulai) {
            $.ajax({
                url: '$urlHitungQuantity',
                type: 'GET',
                data: { produk_id: produk, tanggal_awal: tglMulai, tanggal_akhir: tglSelesai },
                success: function(res) {
                    if (res.status === 'success') {
                        // Matikan dulu listener Qty agar tidak panggil hitungEstimasi lagi
                        $('#jadwalsimulasi-quantity').off('change');
                        
                        $('#jadwalsimulasi-quantity').val(res.qty);
                        $('#jadwalsimulasi-estimasi_selesai').val(res.durasi);
                        
                        rebindEvents();
                    }
                }
            });
        }
    }
    function hitungQtyDariDurasi() {
        let durasi = $('#jadwalsimulasi-estimasi_selesai').val(); // misal: 10
        let tglMulai = $('#jadwalsimulasi-tanggal_mulai').val();
        let produk = $('#jadwalsimulasi-produk_id').val();

        // Hapus kata " Hari" jika ada agar jadi angka murni
        let jumlahHari = parseInt(durasi.replace(/[^0-9]/g, ''));

        if (produk && tglMulai && jumlahHari > 0) {
            // 1. Hitung Tanggal Akhir secara Lokal di JS (Tgl Mulai + Jumlah Hari)
            let date = new Date(tglMulai);
            date.setDate(date.getDate() + jumlahHari);
            
            let tglAkhirOtomatis = date.toISOString().split('T')[0];

            // 2. Update field Dateline dengan tanggal hasil hitungan hari
            $('#jadwalsimulasi-dateline').val(tglAkhirOtomatis);

            // 3. Panggil fungsi hitung Qty yang sudah ada
            hitungQtyOtomatis();
        }
    }

    // 3. Fungsi untuk membungkus Listener agar bisa dimatikan/dihidupkan
    function rebindEvents() {
        // Produk
        $('#jadwalsimulasi-produk_id').off('select2:select').on('select2:select', function () {
            hitungEstimasi();
        });

        // Qty & Tanggal Mulai
        $('#jadwalsimulasi-quantity, #jadwalsimulasi-tanggal_mulai').off('change').on('change', function() {
            hitungEstimasi();
        });

        // Dateline (Tanggal Selesai)
        $('#jadwalsimulasi-dateline').off('change').on('change', function() {
            hitungQtyOtomatis();
        });

        // Durasi (Input angka hari)
        $('#jadwalsimulasi-estimasi_selesai').off('change keyup').on('change keyup', function(){
            // Note: Jika ini readonly, keyup tidak akan jalan.
            // Jika ingin hitung Qty dari jumlah hari, Anda butuh fungsi tambahan
            hitungQtyDariDurasi(); 
        });
    }

// Jalankan bind pertama kali
rebindEvents();

JS;
$this->registerJS($script)
?>