<?php

use app\models\Unit;
use kartik\typeahead\Typeahead;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JqueryAsset;
use yii\web\View;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Bom $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="bom-form">
    <div class="card table-card">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="card-body mx-4">

            <?php $form = ActiveForm::begin(); ?>
            <div id="bom-gridview">
                <?= GridView::widget([
                    'dataProvider' => new \yii\data\ArrayDataProvider([
                        'allModels' => $modelBoms, // Pastikan $modelBoms adalah array model Bom
                        'pagination' => false,
                    ]),
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        [
                            'attribute' => 'produk_id',
                            'label' => 'Nama Produk',
                            'format' => 'raw',
                            'value' => function ($model, $key, $index, $column) use ($form) {
                                return Typeahead::widget([
                                    'name' => "Barang[$index][produk_id]",
                                    'options' => ['placeholder' => 'Cari produk...'],
                                    'pluginOptions' => ['highlight' => true],
                                    'dataset' => [[
                                        'remote' => [
                                            'url' => Url::to(['barang/search-produk']) . '?q=%QUERY',
                                            'wildcard' => '%QUERY',
                                        ],
                                        'display' => 'nama_barang',
                                    ]],
                                    'pluginEvents' => [
                                        "typeahead:select" => "function(e, suggestion) {
                                            $(this).closest('tr').find('input[name*=\"[produk_id]\"]').val(suggestion.barang_id);
                                        }",
                                    ],
                                ]) .
                                    $form->field($model, "[$index]produk_id")->hiddenInput()->label(false);
                            },
                        ],
                        [
                            'attribute' => 'bahan_id',
                            'label' => 'Nama Bahan',
                            'format' => 'raw',
                            'value' => function ($model, $key, $index, $column) use ($form) {
                                return
                                    Typeahead::widget([
                                        'name' => "Barang[$index][bahan_id]",
                                        'options' => ['placeholder' => 'Cari bahan...'],
                                        'pluginOptions' => ['highlight' => true],
                                        'dataset' => [
                                            [
                                                'remote' => [
                                                    'url' => Url::to(['barang/search-bahan']) . '?q=%QUERY',
                                                    'wildcard' => '%QUERY',
                                                ],
                                                'display' => 'nama_barang',
                                            ]
                                        ],
                                        'pluginEvents' => [
                                            "typeahead:select" => "function(e, suggestion) {
                                                $(this).closest('tr').find('input[name*=\"[bahan_id]\"]').val(suggestion.barang_id);
                                            }",
                                        ],
                                    ]) . $form->field($model, "[$index]bahan_id")->hiddenInput()->label(false);
                            },
                        ],
                        [
                            'attribute' => 'qty_per_unit',
                            'format' => 'raw',
                            'value' => function ($model, $key, $index, $column) use ($form) {
                                return $form->field($model, "[$index]qty_per_unit")->textInput(['maxlength' => true])->label(false);
                            },
                        ],
                        [
                            'attribute' => 'unit_id',
                            'format' => 'raw',
                            'label' => 'satuan',
                            'value' => function ($model, $key, $index, $column) use ($form) {
                                $dataPost = ArrayHelper::map(Unit::find()->asArray()->all(), 'unit_id', 'satuan');
                                return $form->field($model, "[$index]unit_id")->dropDownList($dataPost, ['prompt' => 'Pilih Satuan'])->label(false);
                            },
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{actions}',
                            'buttons' => [
                                'actions' => function ($url, $model) {
                                    return Html::tag(
                                        'div',
                                        Html::a(Html::tag('i', '', ['class' => 'fas fa-plus fa-xs']), '#', [
                                            'class' => 'btn btn-success btn-xs pb-1 px-2 add-row ',
                                            'onclick' => 'return false;',
                                        ]) .
                                            Html::a(Html::tag('i', '', ['class' => 'fas fa-trash fa-xs']), '#', [
                                                'class' => 'btn btn-danger btn-xs pb-1 px-2 delete-row ',
                                                'onclick' => 'return false;',
                                            ]),
                                        ['class' => 'd-flex justify-content-between align-content-center align-items-center']
                                    );
                                },
                            ], // Tambahkan kelas untuk gaya CSS khusus
                        ],
                    ],
                ]); ?>
            </div>
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Back', '/barang/index-barang-jadi', ['class' => 'btn btn-secondary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<?php
$dataSatuan = ArrayHelper::map(Unit::find()->asArray()->all(), 'unit_id', 'satuan');
$searchBahanUrl = Url::to(['barang/search-bahan']);
// Create options HTML
$optionsHtml = '';
foreach ($dataSatuan as $unitId => $satuan) {
    $optionsHtml .= "<option value=\"{$unitId}\">{$satuan}</option>";
}
$this->registerJsFile(
    'https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js',
    ['depends' => [JqueryAsset::class]]
);
$js = <<<JS
    // Fungsi untuk mengatur tombol di setiap baris
    function updateRowButtons() {
        var rows = $('#bom-gridview table tbody tr');
        var rowCount = rows.length;

        rows.each(function(index) {
            var isLastRow = index === rowCount - 1;
            $(this).find('.add-row').toggle(isLastRow); // Tampilkan tombol tambah hanya di baris terakhir
            
            // Sembunyikan tombol hapus jika hanya ada satu baris
            if (rowCount === 1) {
                $(this).find('.delete-row').hide();
            } else {
                $(this).find('.delete-row').show(); // Tampilkan tombol hapus di semua baris kecuali jika hanya satu
            }
        });
    }

    // Inisialisasi Typeahead di kolom bahan
    function initTypeahead(context, selector, searchUrl, hiddenSelector) {
        console.log("Typeahead initialized for", $(context).find('.bahan-typeahead').length, "fields");

        $(context).find(selector).typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        }, {
            name: 'bahan',
            display: 'nama_barang',
            limit: 15,
            source: function(query, syncResults, asyncResults) {
                $.getJSON(searchUrl, { q: query }, function(data) {
                    asyncResults(data.data || data); // otomatis pilih sesuai format JSON
                });
            },
            templates: {
                suggestion: function(bahan) {
                    return '<div>' + bahan.nama_barang + '</div>';
                }
            }
        }).bind('typeahead:select', function(ev, suggestion) {
            const parentRow = $(this).closest('tr');
            parentRow.find(hiddenSelector).val(suggestion.barang_id);
        });
    }

    // Panggil fungsi updateRowButtons & initTypeahead saat halaman dimuat
    updateRowButtons();
    initTypeahead($('#table-id'), '.produk-typeahead', '/barang/search-produk', '.produk-id-hidden');
    initTypeahead($('#table-id'), '.bahan-typeahead', '/barang/search-bahan', '.bahan-id-hidden');

    // Fungsi untuk menambahkan baris baru
    $(document).on('click', '.add-row', function(e) {
        e.preventDefault();
        var index = $('#bom-gridview table tbody tr').length;
        var newRow = `
        <tr>
            <td class="serial-number">\${index + 1}</td>
            <td>
                <input type="text" name="Bom[\${index}][produk_nama]" class="form-control produk-typeahead" placeholder="Cari bahan...">
                <input type="hidden" name="Bom[\${index}][produk_id]" class="produk-id-hidden">
            </td>
            <td>
                <input type="text" name="Bom[\${index}][bahan_nama]" class="form-control bahan-typeahead" placeholder="Cari bahan...">
                <input type="hidden" name="Bom[\${index}][bahan_id]" class="bahan-id-hidden">
            </td>
            <td><input type="text" name="Bom[\${index}][qty_per_unit]" class="form-control"></td>
            <td>
                <select name="Bom[\${index}][unit_id]" class="form-control">
                    <option value="">Pilih Satuan</option>
                    {$optionsHtml}
                </select>
            </td>
            <td>
                <div class="d-flex justify-content-between align-content-center align-items-center">
                    <a href="#" class="btn btn-success btn-xs pb-1 px-2 add-row" title="Tambah Baris">
                        <i class="fas fa-plus"></i>
                    </a>
                    <a href="#" class="btn btn-danger btn-xs pb-1 px-2 delete-row" title="Hapus Baris">
                        <i class="fas fa-trash"></i>
                    </a>
                </div>
            </td>
        </tr>`;

        $('#bom-gridview table tbody').append(newRow);
        updateRowButtons();
        initTypeahead($('#bom-gridview'), '.produk-typeahead', '/barang/search-produk', '.produk-id-hidden');
        initTypeahead($('#bom-gridview'), '.bahan-typeahead', '/barang/search-bahan', '.bahan-id-hidden'); // aktifkan typeahead di baris baru
    });

    // Fungsi untuk menghapus baris
    $(document).on('click', '.delete-row', function(e) {
        e.preventDefault();
        $(this).closest('tr').remove();

        // Update nomor urut
        $('#bom-gridview table tbody tr').each(function(index) {
            $(this).find('.serial-number').text(index + 1);
        });

        updateRowButtons();
    });
JS;

$this->registerJs($js, View::POS_READY);
?>
<style>
    .small-btn {
        padding: 2px 6px;
        font-size: 0.8em;
        margin-right: 2px;
    }

    /* Mengatur tata letak tombol secara horizontal */
    .action-buttons {
        display: flex;
        align-items: center;
        gap: 4px;
    }
</style>