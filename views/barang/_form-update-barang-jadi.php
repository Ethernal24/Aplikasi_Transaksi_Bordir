<?php

use app\models\Barang;
use app\models\Unit;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\base\View;
use yii\bootstrap5\Alert as Bootstrap5Alert;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;

/** @var yii\web\View $this */
/** @var app\models\Barang $modelBarangmodel */
/** @var yii\widgets\ActiveForm $form */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Update Barang  ';
?>

<div class="pc-content">
    <div class="card table-card">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
            <!-- Tombol Consumable dan Non Consumable -->
        </div>

        <div class="card-body mx-4">
            <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

            <div class="row">
                <div class="col">
                    <?= $form->field($modelBarang, 'kode_barang')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col">
                    <?= $form->field($modelBarang, 'nama_barang')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col">
                    <?= $form->field($modelBarang, 'jenis')->label('Jenis')->dropDownList([
                        0 => 'Beli',
                        1 => 'Produksi',
                    ]) ?>
                </div>
                <div class="col">
                    <?= $form->field($modelBarang, 'unit_id')->dropDownList(
                        ArrayHelper::map(Unit::find()->asArray()->all(), 'unit_id', 'satuan'),
                        ['prompt' => 'Pilih Satuan']
                    ) ?>
                </div>

                <div class="col">
                    <?php
                    // Field tipe_barang hanya beda tampilannya
                    if ($modelBarang->tipe_barang == 2 || $modelBarang->tipe_barang == 4) {
                        $list = [
                            2 => 'Barang jadi',
                            4 => 'Template',
                        ];
                        echo $form->field($modelBarang, 'tipe_barang')->dropDownList($list, ['promt' => 'Pilih tipe barang']);
                    } else {
                        // Bahan Baku atau Setengah Jadi → dropdown biasa
                        $list = [
                            0 => 'Bahan Baku',
                            1 => 'Setengah Jadi',
                            3 => 'Non Consumable',
                        ];
                        echo $form->field($modelBarang, 'tipe_barang')->dropDownList($list, ['prompt' => 'Pilih Tipe Barang']);
                    }
                    ?>
                </div>
                <div class="col">
                    <?= $form->field($modelBarang, 'leadtime')->textInput(['maxlength' => true]) ?>
                </div>

                <?php DynamicFormWidget::begin([
                    'widgetContainer' => 'dynamicform_wrapper',
                    'widgetBody' => '.container-items',
                    'widgetItem' => '.item',
                    'limit' => 20,
                    'min' => 1,
                    'insertButton' => '.add-item',
                    'deleteButton' => '.remove-item',
                    'model' => $modelBoms[0],
                    'formId' => 'dynamic-form',
                    'formFields' => [
                        'produk_id',
                        'bahan_id',
                        'qty_per_unit',
                        'unit_id',
                    ],
                ]); ?>

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>bahan</th>
                            <th>qty</th>
                            <th>satuan</th>
                            <th class="text-center" style="width: 90px;">
                                <button type="button" class="add-item btn btn-success btn-xs"><i class="fas fa-plus"></i></button>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="container-items">
                        <?php foreach ($modelBoms as $i => $boms): ?>
                            <tr class="item">
                                <td class="vcenter">
                                    <?php
                                    // Simpan semua ID hidden di kolom pertama agar rapi
                                    if (!$boms->isNewRecord) {
                                        echo Html::activeHiddenInput($boms, "[{$i}]bom_id");
                                    }
                                    // Hidden input produk_id
                                    echo $form->field($boms, "[{$i}]produk_id", ['template' => '{input}'])->hiddenInput([
                                        'value' => $modelBarang->barang_id,
                                    ])->label(false);
                                    ?>

                                    <?= $form->field($boms, "[{$i}]bahan_id", ['template' => "{input}\n{error}"])->widget(Select2::classname(), [
                                        'options' => [

                                            'placeholder' => 'Pilih bahan...',
                                            'class' => 'my-select2-custom',
                                        ],
                                        'data' => ArrayHelper::map(Barang::find()
                                            ->asArray()
                                            ->where(['tipe_barang' => 0])
                                            ->all(), 'barang_id', 'nama_barang'),
                                        'pluginOptions' => [
                                            'allowClear' => true,
                                        ],
                                    ])->label(false) ?>
                                </td>
                                <td>
                                    <?= $form->field($boms, "[{$i}]qty_per_unit", ['template' => "{input}\n{error}"])->textInput(['type' => 'number', 'step' => 'any']) ?>
                                </td>
                                <td>
                                    <?= $form->field($boms, "[{$i}]unit_id", ['template' => "{input}\n{error}"])->widget(Select2::classname(), [
                                        'options' => [
                                            'placeholder' => 'Satuan...',
                                            'class' => 'my-select2-custom',
                                        ],
                                        'data' => ArrayHelper::map(Unit::find()->asArray()->all(), 'unit_id', 'satuan')
                                    ])->label(false) ?>
                                </td>
                                <td class="text-center vcenter">
                                    <button type="button" class="remove-item btn btn-danger btn-xs"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php DynamicFormWidget::end(); ?>

                <div class="form-group">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                    <?= Html::a('Back', [$backUrl], ['class' => 'btn btn-secondary']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<?php
$js = <<<JS
function reinitSelect2Dynamic(item) {
    $(item).find('.my-select2-custom').each(function () {
        var el = $(this);
        
        // 1. HAPUS PAKSA ANIMASI LOADING & CONTAINER LAMA
        el.removeClass('select2-hidden-accessible');
        el.next('.select2-container').remove(); 
        
        // Menghapus class loading yang mungkin terbawa dari baris sebelumnya
        // Serta menghapus ID unik select2 agar tidak konflik
        el.removeClass('select2-loading'); 
        el.removeAttr('data-select2-id');
        el.find('option').removeAttr('data-select2-id');

        // 2. BERSIHKAN DATA INTERNAl
        if (el.data('select2')) {
            el.select2('destroy');
        }
        el.val(null); // Kosongkan pilihan di baris baru

        // 3. RE-INISIALISASI BERSIH
        var configAttr = el.attr('data-krajee-select2');
        if (configAttr && window[configAttr]) {
            var settings = window[configAttr];
            el.select2(settings);
        }
    });
}

// Event afterInsert tetap sama
$(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    // Pastikan nilai produk_id terisi di baris baru
    var barangId = "<?= $modelBarang->barang_id ?>";
    $(item).find('input[id$="-produk_id"]').val(barangId);
    
    // Jalankan re-init select2
    reinitSelect2Dynamic(item);
});
// Tetap gunakan Monkey Patch untuk mencegah error 'destroy'
$.fn.select2 = (function(originalSelect2) {
    return function(options) {
        if (options === 'destroy' && !this.data('select2')) {
            return this;
        }
        return originalSelect2.apply(this, arguments);
    };
})($.fn.select2);

// Timpa fungsi loading bawaan agar tidak 'nyangkut'
window.initSelect2Loading = function(id, opt) {
    $('#' + id).removeClass('select2-loading');
    return true;
};
JS;

$this->registerJs($js);
?>