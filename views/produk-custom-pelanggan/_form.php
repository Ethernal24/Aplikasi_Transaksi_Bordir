<?php

use app\models\Barang;
use app\models\Unit;
use kartik\grid\ExpandRowColumn;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="produk-custom-pelanggan-form">
    <div class="card table-card">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="card-body mx-4">
            <?php $form = ActiveForm::begin(['id' => 'produk-custom-form']); ?>



            <table class="table table-bordered" id="produk-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang Custom</th>
                        <th style="width: 180px;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="produk-body">
                    <?php foreach ($model as $i => $produk): ?>
                        <tr class="produk-row" data-index="<?= $i ?>">
                            <td class="align-middle"><?= $i + 1 ?></td>
                            <?= html::hiddenInput('pelanggan_id') ?>
                            <?= Html::activeHiddenInput($produk, "[$i]produk_custom_pelanggan_id") ?>

                            <td>
                                <?= $form->field($produk, "[$i]kode_barang")
                                    ->textInput([
                                        'class' => 'form-control',
                                        'readonly' => true,
                                    ])
                                    ->label(false) ?>
                            </td>
                            <td><?= $form->field($produk, "[$i]nama_barang_custom")->textInput(['class' => 'form-control'])->label(false) ?></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-primary toggle-bom" data-target="#bom-<?= $i ?>">
                                    <i class="fa fa-list"></i> BOM
                                </button>
                                <button type="button" class="btn btn-sm btn-success add-produk"><i class="fa fa-plus"></i></button>
                                <button type="button" class="btn btn-sm btn-danger remove-produk"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>

                        <tr id="bom-<?= $i ?>" class="bom-row" data-produk-index="<?= $i ?>" style="display:none;">
                            <td colspan="4">
                                <div class="bom-wrapper">
                                    <table class="table table-bordered table-sm table-striped bom-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Bahan</th>
                                                <th>Kuantitas</th>
                                                <th>Satuan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($modelsBom[$i] as $j => $bom): ?>
                                                <tr class="bom-item">
                                                    <td class="align-middle"><?= $i + 1 ?></td>
                                                    <td><?= $form->field($bom, "[$i][$j]bahan_id")
                                                            ->dropDownList(
                                                                ArrayHelper::map(Barang::find()
                                                                    ->asArray()
                                                                    ->where(['tipe_barang' => 0])
                                                                    ->all(), 'barang_id', 'nama_barang'),
                                                                ['prompt' => 'Pilih Bahan']
                                                            )->label(false) ?></td>
                                                    <td><?= $form->field($bom, "[$i][$j]qty_per_unit")->textInput(['class' => 'form-control'])->label(false) ?></td>
                                                    <td><?= $form->field($bom, "[$i][$j]unit_id")
                                                            ->dropDownList(
                                                                ArrayHelper::map(Unit::find()
                                                                    ->asArray()
                                                                    ->all(), 'unit_id', 'satuan'),
                                                                ['prompt' => 'Pilih Satuan']
                                                            )
                                                            ->label(false) ?></td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-sm btn-success add-bom"><i class="fa fa-plus"></i></button>
                                                        <button type="button" class="btn btn-sm btn-danger remove-bom"><i class="fa fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="mt-3">
                <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Back', ['master-pelanggan/view', 'pelanggan_id' => $pelanggan_id], ['class' => 'btn btn-secondary']) ?> </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<?php
$dataSatuan = ArrayHelper::map(Unit::find()->asArray()->all(), 'unit_id', 'satuan');

// Create options HTML
$optionsHtml = '';
foreach ($dataSatuan as $unitId => $satuan) {
    $optionsHtml .= "<option value=\"{$unitId}\">{$satuan}</option>";
}
$dataBahan = ArrayHelper::map(Barang::find()
    ->asArray()
    ->where(['tipe_barang' => 0])
    ->all(), 'barang_id', 'nama_barang');
$bahanOption = '';
foreach ($dataBahan as $bahan_id => $nama_barang) {
    $bahanOption .= "<option value=\"{$bahan_id}\">{$nama_barang}</option>";
}

$kodePelanggan = $kode_pelanggan; // ambil dari PHP
$lastNumberVal = $lastNumber ?? 0; // pastikan ada nilai default


// Template produk (hidden)
$produkTemplate = str_replace("\n", "", $this->render('_produk_template', [
    'form' => $form,
    'bahanOption' => $bahanOption,
    'optionsHtml' => $optionsHtml,
    'kode_pelanggan' => $kode_pelanggan,
]));
$js = <<<JS
var kodePelanggan = "{$kodePelanggan}";
var lastNumber = "{$lastNumberVal}"; // dari controller (nomor terakhir di DB)
// ====== Toggle BOM visibility ======
$(document).on('click', '.toggle-bom', function() {
    var target = $(this).data('target');
    $(target).toggle();
});

// ====== Add produk ======
$(document).on('click', '.add-produk', function() {
    var index = $('#produk-body .produk-row').length;
    var newRow = `$produkTemplate`.replace(/__INDEX__/g, index);
    $('#produk-body').append(newRow);
    updateProdukNumbers();
});

// ====== Remove produk ======
$(document).on('click', '.remove-produk', function() {
    if ($('#produk-body .produk-row').length > 1) {
        $(this).closest('tr').next('.bom-row').remove();
        $(this).closest('tr').remove();
    }
    updateProdukNumbers();
});

// ====== Add BOM ======
$(document).on('click', '.add-bom', function() {
    var tbody = $(this).closest('tbody');
    var produkIndex = $(this).closest('.bom-row').prev('.produk-row').data('index');
    var rowCount = tbody.find('tr').length;
    var newRow = `
        <tr class="bom-item">
            <td class="align-middle">\${rowCount + 1}</td>
            <td>
                <select name="BomCustom[\${produkIndex}][\${rowCount}][bahan_id]" class="form-control">
                    <option value="">Pilih bahan</option>
                    $bahanOption
                </select>
            </td>
            <td><input type="text" name="BomCustom[\${produkIndex}][\${rowCount}][qty_per_unit]" class="form-control"></td>
            <td>
                <select name="BomCustom[\${produkIndex}][\${rowCount}][unit_id]" class="form-control">
                    <option value="">Pilih Satuan</option>
                    $optionsHtml
                </select>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-sm btn-success add-bom"><i class="fa fa-plus"></i></button>
                <button type="button" class="btn btn-sm btn-danger remove-bom"><i class="fa fa-trash"></i></button>
            </td>
        </tr>`;
    tbody.append(newRow);
});

// ====== Update nomor urut produk ======
function updateProdukNumbers() {
    $('#produk-body .produk-row').each(function(i) {
        $(this).attr('data-index', i); // update index produk
        $(this).find('td:first').text(i + 1);

        var kodeInput = $(this).find('input[name*="[kode_barang]"]');
        if ((!kodeInput.val() || kodeInput.val().trim() === '') && !kodeInput.attr('data-generated')) {
            lastNumber++;
            var kodeBaru = kodePelanggan + '-' + String(lastNumber).padStart(2, '0');
            kodeInput.val(kodeBaru);
            kodeInput.attr('data-generated', 'true');
        }

        // Update name untuk produk
        $(this).find('input, select, textarea').each(function() {
            var name = $(this).attr('name');
            if (name && name.includes('ProdukCustomPelanggan')) {
                name = name.replace(/ProdukCustomPelanggan\[\d+\]/, 'ProdukCustomPelanggan[' + i + ']');
                $(this).attr('name', name);
            }
        });

        // Update semua BOM yang punya data-produk-index sama
        $('.bom-row[data-produk-index="' + $(this).data('index') + '"]').each(function() {
            $(this).attr('data-produk-index', i); // update ke index baru
            $(this).find('input, select, textarea').each(function() {
                var name = $(this).attr('name');
                if (name && name.includes('BomCustom')) {
                    name = name.replace(/BomCustom\[\d+\]/, 'BomCustom[' + i + ']');
                    $(this).attr('name', name);
                }
            });
        });
    });
}

// ====== Remove BOM ======
$(document).on('click', '.remove-bom', function() {
    if ($(this).closest('tbody').find('tr').length > 1) {
        $(this).closest('tr').remove();
    }
});
JS;

$this->registerJs($js);
?>