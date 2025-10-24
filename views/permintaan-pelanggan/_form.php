<?php

use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\PermintaanPelanggan $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="permintaan-pelanggan-form">

    <div class="card table-card">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="card-body mx-4">
            <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
            <div class="row">
                <div class="col">
                    <?= $form->field($model, 'kode_permintaan')->textInput(['readonly' => true]) ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'pelanggan_id')->dropDownList(
                        \yii\helpers\ArrayHelper::map(\app\models\MasterPelanggan::find()
                            ->all(), 'pelanggan_id', 'nama_pelanggan'),
                        [
                            'prompt' => 'Pilih Pelanggan',
                            'id' => 'pelanggan-id', // penting
                        ]
                    )->label('Nama Pelanggan') ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'tanggal_permintaan')->widget(DatePicker::className(), [
                        'dateFormat' => 'yyyy-MM-dd', // format yang sesuai database
                        'options' => ['class' => 'form-control', 'placeholder' => 'Pilih Tanggal'],
                    ]) ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'tenggat_waktu')->widget(DatePicker::className(), [
                        'dateFormat' => 'yyyy-MM-dd', // format yang sesuai database
                        'options' => ['class' => 'form-control', 'placeholder' => 'Pilih Tanggal'],
                    ]) ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'status_pesanan')
                        ->dropDownList(
                            [
                                0 => 'Antrian',
                                1 => 'Proses',
                                2 => 'Selesai',
                            ],
                            [
                                'prompt' => 'Pilih status pesanan...',
                                'class' => 'form-control tipe-field',
                            ]
                        ) ?>
                </div>
            </div>



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
                'formFields' => ['barang_id', 'jumlah'],
            ]); ?>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="width: 40%;">Barang</th>
                        <th style="width: 25%;">Jumlah</th>
                        <th style="width: 25%;">Deskripsi</th>
                        <th style="width: 10%; text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="container-items">
                    <?php foreach ($modelDetails as $i => $detail): ?>
                        <tr class="item">
                            <td>
                                <?= $form->field($detail, "[{$i}]produk_custom_pelanggan_id", ['template' => "{input}\n{error}"])
                                    ->dropDownList(
                                        [],
                                        [
                                            'prompt' => 'Pilih Barang',
                                            'class' => 'barang-dropdown form-control',
                                        ]
                                    ) ?>
                            </td>
                            <td>
                                <?= $form->field($detail, "[{$i}]jumlah", ['template' => "{input}\n{error}"])
                                    ->textInput(['type' => 'number', 'min' => 1]) ?>
                            </td>
                            <td>
                                <?= $form->field($detail, "[{$i}]deskripsi", ['template' => "{input}\n{error}"])
                                    ->textInput(['type' => 'text']) ?>
                            </td>
                            <td style="text-align:center;">
                                <button type="button" class="remove-item btn btn-danger btn-sm">
                                    <i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="add-item btn btn-success btn-sm">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <?php DynamicFormWidget::end(); ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                <?php if ($model->isNewRecord): ?>
                    <?= Html::a('Back', ['index'], ['class' => 'btn btn-secondary']) ?>
                <?php else: ?>
                    <?= Html::a('Back', ['view', 'permintaan_id' => $model->permintaan_id], ['class' => 'btn btn-secondary']) ?>
                <?php endif; ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<?php

$urlGetBarang = Url::to(['permintaan-pelanggan/get-barang-by-pelanggan']);
$js = <<<JS
    $('#pelanggan-id').on('change', function() {
    var pelangganId = $(this).val();

    if (!pelangganId) {
        // reset semua dropdown barang jika pelanggan belum dipilih
        $('.barang-dropdown').html('<option value="">Pilih Barang</option>');
        return;
    }

    $.ajax({
        url: '{$urlGetBarang}',
        type: 'GET',
        data: { pelanggan_id: pelangganId },
        success: function(response) {
            $('.barang-dropdown').each(function() {
                $(this).html(response); // isi ulang semua dropdown barang
            });
        },
        error: function() {
            alert('Gagal mengambil data barang.');
        }
    });
});
JS;
$this->registerJs($js);
?>