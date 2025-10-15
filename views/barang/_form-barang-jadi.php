<?php

use app\models\Barang;
use app\models\Unit;
use yii\bootstrap5\Alert as Bootstrap5Alert;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;

/** @var yii\web\View $this */
/** @var app\models\Barang $model */
/** @var yii\widgets\ActiveForm $form */
/** @var yii\data\ActiveDataProvider $dataProvider */


?>

<div class="barang-form">
    <div class="card table-card">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
            <!-- Tambahkan tombol Toggle -->
            <!-- Tombol Consumable dan Non Consumable -->
        </div>
        <div class="card-body mx-4">

            <?php $form = ActiveForm::begin(); ?>
            <div id="barang-gridview">
                <?= GridView::widget([
                    'dataProvider' => new \yii\data\ArrayDataProvider([
                        'allModels' => $modelBarangs, // Pastikan $modelBarangs adalah array model Barang
                        'pagination' => false,
                    ]),
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        [
                            'attribute' => 'kode_barang',
                            'format' => 'raw',
                            'value' => function ($model, $key, $index, $column) use ($form) {
                                return $form->field($model, "[$index]kode_barang")->textInput(['maxlength' => true])->label(false);
                            },
                        ],
                        [
                            'attribute' => 'nama_barang',
                            'format' => 'raw',
                            'value' => function ($model, $key, $index, $column) use ($form) {
                                return $form->field($model, "[$index]nama_barang")->textInput(['maxlength' => true])->label(false);
                            },
                        ],
                        [
                            'attribute' => 'Jenis',
                            'format' => 'raw',
                            'value' => function ($model, $key, $index, $column) use ($form) {
                                $list = [
                                    0 => 'Beli',
                                    1 => 'Produksi',
                                ];
                                return $form->field($model, "[$index]jenis")->dropDownList(
                                    $list,
                                    [
                                        'class' => 'form-control tipe-field',
                                        'prompt' => 'Pilih jenis  ',
                                    ]
                                )->label(false);
                            },
                        ],

                        [
                            'attribute' => 'unit_id',
                            'format' => 'raw',
                            'value' => function ($model, $key, $index, $column) use ($form) {
                                $dataPost = ArrayHelper::map(Unit::find()->asArray()->all(), 'unit_id', 'satuan');
                                return $form->field($model, "[$index]unit_id")->dropDownList($dataPost, ['prompt' => 'Pilih Satuan'])->label(false);
                            },
                        ],
                        [
                            'attribute' => 'tipe_barang',
                            'format' => 'raw',
                            'value' => function ($model, $key, $index, $column) use ($form) {
                                return $form->field($model, "[$index]tipe_barang")
                                    ->dropDownList(
                                        [
                                            2 => 'Barang Jadi',
                                            4 => 'Template',
                                        ], // hanya satu opsi
                                        [
                                            'class' => 'form-control tipe-field',
                                            'prompt' => 'Pilih tipe barang...',
                                        ]
                                    )
                                    ->label(false);
                            },
                        ],
                        [
                            'attribute' => 'leadtime',
                            'format' => 'raw',
                            'value' => function ($model, $key, $index, $column) use ($form) {
                                return $form->field($model, "[$index]leadtime")->textInput(['maxlength' => true])->label(false);
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
                <?= Html::a('Back', 'index-barang-jadi', ['class' => 'btn btn-secondary']) ?>
            </div>

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

$js = <<<JS
    // Fungsi untuk mengatur tombol di setiap baris
    function updateRowButtons() {
        var rows = $('#barang-gridview table tbody tr');
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

    // Panggil fungsi updateRowButtons saat halaman dimuat
    updateRowButtons();

    // Fungsi untuk menambahkan baris baru
    $(document).on('click', '.add-row', function(e) {
        e.preventDefault();
        // Ambil jumlah baris yang ada
        var index = $('#barang-gridview table tbody tr').length;
        var newRow = `<tr>
            <td class="serial-number">\${index + 1}</td>
            <td><input type="text" name="Barang[\${index}][kode_barang]" class="form-control" maxlength="true"></td>
            <td><input type="text" name="Barang[\${index}][nama_barang]" class="form-control" maxlength="true"></td>
            <td>
                <select name="Barang[\${index}][jenis]" class="form-control tipe-field">
                    <option value = ""> Pilih Jenis </option>
                    <option value = "0"> Beli </option>
                    <option value = "1"> Produksi </option>
                </select
            </td>
            
            <td>
                <select name="Barang[\${index}][unit_id]" class="form-control">
                    <option value="">Pilih Satuan</option>
                    $optionsHtml <!-- Use the options generated in PHP -->
                </select>
            </td>
            <td>
                <select name="Barang[\${index}][tipe_barang]" class="form-control tipe-field">  
                    <option value = ""> Pilih tipe barang... </option>
                    <option value = "2"> Barang Jadi </option>
                    <option value = "4"> Template </option>
                </select
            </td>
            <td><input type="text" name="Barang[\${index}][leadtime]" class="form-control" maxlength="true"></td>
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
        
        $('#barang-gridview table tbody').append(newRow);
        updateRowButtons(); // Perbarui tampilan tombol setelah menambah baris
    });

    // Fungsi untuk menghapus baris yang dipilih
    $(document).on('click', '.delete-row', function(e) {
        e.preventDefault();
        $(this).closest('tr').remove();

        // Update nomor urut pada kolom serial
        $('#barang-gridview table tbody tr').each(function(index) {
            $(this).find('.serial-number').text(index + 1);
        });
        updateRowButtons(); // Perbarui tampilan tombol setelah menghapus baris
    });
JS;
$this->registerJs($js);
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