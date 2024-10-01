<?php

use kartik\typeahead\Typeahead;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\PesanDetail $model */
/** @var yii\widgets\ActiveForm $form */
/** @var int $pemesananId */

$pemesananId = Yii::$app->session->get('temporaryOrderId'); // Ambil pemesanan_id dari session
Yii::debug("Pemesanan ID yang digunakan: " . $pemesananId, __METHOD__); // Debugging pemesanan_id

?>

<div class="pesan-detail-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'method' => 'post']); ?>

    <!-- Hidden Field for pemesanan_id -->
    <?= Html::activeHiddenInput($modelDetail[0], '[0]pemesanan_id', ['value' => $pemesananId]) ?>
    <?= $form->field($modelDetail[0], '[0]pemesanan_id')->textInput(['readonly' => true, 'value' => $pemesananId]) ?>

    <?= $form->field($modelDetail[0], '[0]barang_id')->widget(Typeahead::classname(), [
        'options' => ['placeholder' => 'Cari Nama Barang...', 'id' => 'pesandetail-0-barang_id'],
        'pluginOptions' => ['highlight' => true],
        'scrollable' => true,
        'dataset' => [
            [
                'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                'display' => 'value',
                'templates' => [
                    'notFound' => "<div class='text-danger'>Tidak ada hasil</div>",
                    'suggestion' => new \yii\web\JsExpression('function(data) {
                return "<div>" + data.barang_id +  " - " + data.kode_barang + " - " + data.nama_barang + " - " + data.angka + " " + data.satuan + " - " + data.warna + "</div>";
            }'),
                ],
                'remote' => [
                    'url' => Url::to(['pesan-detail/search']) . '?q=%QUERY',
                    'wildcard' => '%QUERY',
                ],
            ]
        ],
        'pluginEvents' => [
            "typeahead:select" => new \yii\web\JsExpression('function(event, suggestion) {
        $("#pesandetail-0-barang_id").val(suggestion.id);
    }')
        ]
    ]); ?>

    <?= $form->field($modelDetail[0], '[0]qty')->textInput(['id' => 'pesandetail-0-qty']) ?>
    <?= $form->field($modelDetail[0], '[0]qty_terima')->textInput(['id' => 'pesandetail-0-qty_terima']) ?>
    <?= $form->field($modelDetail[0], '[0]catatan')->textInput(['maxlength' => true, 'id' => 'pesandetail-0-catatan']) ?>
    <?= $form->field($modelDetail[0], '[0]langsung_pakai')->checkbox(['id' => 'pesandetail-0-langsung_pakai']) ?>
    <?= $form->field($modelDetail[0], '[0]is_correct')->checkbox(['id' => 'pesandetail-0-is_correct']) ?>


    <div id="new-form-container"></div>

    <div class="form-group">
        <?= Html::button('Tambah Data Lain', ['class' => 'btn btn-success', 'id' => 'add-more']) ?>
        <!-- <button type="button" id="add-more" class="btn btn-success">Tambah Data Lain</button> -->
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Back', ['pesan-detail/index'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
// Variabel PHP untuk URL
$urlSearch = Url::to(['pesan-detail/search']);

$js = <<<JS
$(document).ready(function() {
    let index = 1; // Mulai dengan indeks 1 untuk form berikutnya
    const pemesananId = '{$pemesananId}'; // Menyimpan pemesanan_id dari session

    // Event listener untuk tombol tambah data
    $('#add-more').click(function() {
        let newForm = `
        <div class="pemesanan-item" id="pemesanan-item-\${index}">
            <div class="form-group">
                <label for="pesandetail-\${index}-pemesanan_id">Pemesanan ID</label>
                <input type="text" id="pesandetail-\${index}-pemesanan_id" class="form-control" name="PesanDetail[\${index}][pemesanan_id]" value="\${pemesananId}" readonly>
            </div>
            <div class="form-group">
                <label for="pesandetail-\${index}-barang_id">Barang ID</label>
                <input type="text" id="pesandetail-\${index}-barang_id" class="form-control" name="PesanDetail[\${index}][barang_id]" required>
            </div>
            <div class="form-group">
                <label for="pesandetail-\${index}-qty">Qty</label>
                <input type="number" id="pesandetail-\${index}-qty" class="form-control" name="PesanDetail[\${index}][qty]" required>
            </div>
            <div class="form-group">
                <label for="pesandetail-\${index}-qty_terima">Qty Terima</label>
                <input type="number" id="pesandetail-\${index}-qty_terima" class="form-control" name="PesanDetail[\${index}][qty_terima]" required>
            </div>
            <div class="form-group">
                <label for="pesandetail-\${index}-catatan">Catatan</label>
                <input type="text" id="pesandetail-\${index}-catatan" class="form-control" name="PesanDetail[\${index}][catatan]">
            </div>
            <div class="form-group">
                <div class="checkbox">
                <input type="hidden" name="PesanDetail[\${index}][langsung_pakai]" value="0">
                    <label for="pesandetail-\${index}-langsung_pakai">
                        <input type="checkbox" id="pesandetail-\${index}-langsung_pakai" name="PesanDetail[\${index}][langsung_pakai]" value="1"> Langsung Pakai
                    </label>
                </div>
            </div>
            <div class="form-group">
                <div class="checkbox">
                <input type="hidden" name="PesanDetail[\${index}][is_correct]" value="0">
                    <label for="pesandetail-\${index}-is_correct">
                        <input type="checkbox" id="pesandetail-\${index}-is_correct" name="PesanDetail[\${index}][is_correct]" value="1"> Barang Sesuai
                    </label>
                </div>
            </div>

            <div class="form-group">
                <button type="button" class="btn btn-danger remove-item" data-id="\${index}">Remove Data Lain</button>
            </div>
        </div>
        `;
        $('#new-form-container').append(newForm); // Tambah form baru ke container

        // Inisialisasi Typeahead untuk elemen yang baru saja ditambahkan
        initializeTypeahead(index);

        // Daftarkan elemen baru ke sistem validasi Yii
        $('#dynamic-form').yiiActiveForm('add', {
            id: 'pesandetail-' + index + '-barang_id',
            name: 'PesanDetail[' + index + '][barang_id]',
            container: '.field-pesandetail-' + index + '-barang_id',
            input: '#pesandetail-' + index + '-barang_id',
            validate: function(attribute, value, messages, deferred, \$form) {
                yii.validation.required(value, messages, {message: "Barang ID tidak boleh kosong."});
            }
        });

        $('#dynamic-form').yiiActiveForm('add', {
            id: 'pesandetail-' + index + '-qty',
            name: 'PesanDetail[' + index + '][qty]',
            container: '.field-pesandetail-' + index + '-qty',
            input: '#pesandetail-' + index + '-qty',
            validate: function(attribute, value, messages, deferred, \$form) {
                yii.validation.required(value, messages, {message: "Qty tidak boleh kosong."});
            }
        });

        $('#dynamic-form').yiiActiveForm('add', {
            id: 'pesandetail-' + index + '-qty_terima',
            name: 'PesanDetail[' + index + '][qty_terima]',
            container: '.field-pesandetail-' + index + '-qty_terima',
            input: '#pesandetail-' + index + '-qty_terima',
            validate: function(attribute, value, messages, deferred, \$form) {
                yii.validation.required(value, messages, {message: "Qty Terima tidak boleh kosong."});
            }
        });

        index++; // Naikkan indeks untuk form berikutnya
    });

    // Delegasi event untuk tombol remove, sehingga berfungsi untuk elemen dinamis
    $(document).on('click', '.remove-item', function() {
        let id = $(this).data('id');
        $('#pemesanan-item-' + id).remove(); // Hapus elemen form terkait
    });

    // Fungsi untuk menginisialisasi Typeahead pada elemen dinamis
    function initializeTypeahead(index) {
        $('#pesandetail-' + index + '-barang_id').typeahead({
            highlight: true,
            minLength: 1
        }, {
            name: 'barang',
            display: 'value',
            source: function(query, syncResults, asyncResults) {
                $.get('{$urlSearch}?q=' + query, function(data) {
                    if (Array.isArray(data)) {
                        asyncResults(data);
                    }
                });
            },
            templates: {
                suggestion: function(data) {
                    return "<div>" + data.barang_id + " - " + data.kode_barang + " - " + data.nama_barang + " - " + data.angka + " " + data.satuan + " - " + data.warna + "</div>";
                }
            }
        });
    }
});

JS;

// Daftarkan JavaScript ke halaman ini
$this->registerJs($js);
?>