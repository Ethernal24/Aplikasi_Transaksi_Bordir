<?php

use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TenagaKerja $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tenaga-kerja-form">
    <div class="card table-card">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="card-body mx-4">
            <?php $form = ActiveForm::begin(); ?>
            <div id="barang-gridview">
                <?= GridView::widget([
                    'dataProvider' => new \yii\data\ArrayDataProvider([
                        'allModels' => $modelTenagas, // Pastikan $modelTenagas adalah array model Barang
                        'pagination' => false,
                    ]),
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        [
                            'attribute' => 'nama',
                            'format' => 'raw',
                            'value' => function ($model, $key, $index, $column) use ($form) {
                                return $form->field($model, "[$index]nama")->textInput(['maxlength' => true])->label(false);
                            },
                        ],
                        [
                            'attribute' => 'jabatan',
                            'format' => 'raw',
                            'value' => function ($model, $key, $index, $column) use ($form) {
                                return $form->field($model, "[$index]jabatan")->textInput(['maxlength' => true])->label(false);
                            },
                        ],
                        [
                            'attribute' => 'kemampuan',
                            'format' => 'raw',
                            'value' => function ($model, $key, $index, $column) use ($form) {
                                return $form->field($model, "[$index]kemampuan")->textInput(['maxlength' => true])->label(false);
                            },
                        ],
                        [
                            'attribute' => 'status_kerja',
                            'format' => 'raw',
                            'value' => function ($model, $key, $index, $column) use ($form) {
                                return $form->field($model, "[$index]status_kerja")
                                    ->dropDownList(
                                        [
                                            0 => 'Available',
                                            1 => 'Off',
                                        ],
                                        [
                                            'class' => 'form-control tipe-field',
                                            'prompt' => 'Pilih Status Kerja',
                                        ]
                                    )
                                    ->label(false);
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
                                        ['class' => 'd-flex justify-content-center gap-1 align-content-center align-items-center']
                                    );
                                },
                            ], // Tambahkan kelas untuk gaya CSS khusus
                        ],
                    ],
                ]); ?>
            </div>
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Back', 'index', ['class' => 'btn btn-secondary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<?php
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
            <td><input type="text" name="TenagaKerja[\${index}][nama]" class="form-control" maxlength="true"></td>
            <td><input type="text" name="TenagaKerja[\${index}][jabatan]" class="form-control" maxlength="true"></td>
            <td><input type="text" name="TenagaKerja[\${index}][kemampuan]" class="form-control" maxlength="true"></td>
            <td>
                <select name="TenagaKerja[\${index}][status_kerja]" class="form-control tipe-field">
                    <option value = ""> Pilih Status Kerja </option>
                    <option value = "0"> Available </option>
                    <option value = "1"> Off </option>
                </select
            </td>
            <td>
                <div class="d-flex justify-content-center gap-1 align-content-center align-items-center">
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