<?php

use app\models\Barang;
use app\models\Unit;
use kartik\select2\Select2;
use kartik\typeahead\Typeahead;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JqueryAsset;
use yii\web\JsExpression;
use yii\web\View;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Bom $model */
/** @var yii\widgets\ActiveForm $form */


$dataSatuan = ArrayHelper::map(Unit::find()->asArray()->all(), 'unit_id', 'satuan');
?>

<div class="bom-form">
    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <div class="card">
        <div class="card-header">
            <h1 class="mb-0">Bill of Materials</h1>
        </div>

        <div class="card-body">
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

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 30%">Produk</th>
                        <th style="width: 30%">Bahan</th>
                        <th>Qty</th>
                        <th style="width: 15%">Satuan</th>
                        <th class="text-center" style="width: 90px;">
                            <button type="button" class="add-item btn btn-success btn-xs"><i class="fas fa-plus"></i></button>
                        </th>
                    </tr>
                </thead>
                <tbody class="container-items">
                    <?php foreach ($modelBoms as $i => $modelBom): ?>
                        <tr class="item">
                            <td class="vcenter">
                                <?php
                                // Field Produk (Ajax Select2)
                                echo $form->field($modelBom, "[$i]produk_id")->widget(Select2::class, [
                                    'options' => [
                                        'placeholder' => 'Pilih Produk...',
                                        'class' => 'my-select2-custom', // JANGAN gunakan class bawaan select2/kartik
                                        'data-s2-config' => 's2_config_'
                                    ],
                                    'data' => ArrayHelper::map(Barang::find()
                                        ->asArray()
                                        ->where(['tipe_barang' => 2])
                                        ->all(), 'barang_id', 'nama_barang'),

                                    'pluginOptions' => [
                                        'allowClear' => true,
                                    ],
                                ])->label(false);
                                ?>
                            </td>
                            <td>
                                <?php
                                // Field Bahan (Ajax Select2)
                                echo $form->field($modelBom, "[$i]bahan_id")->widget(Select2::class, [
                                    'options' => ['placeholder' => 'Pilih Bahan...', 'class' => 'select2-remote-bahan'],
                                    'data' => ArrayHelper::map(Barang::find()
                                        ->asArray()
                                        ->where(['tipe_barang' => 0])
                                        ->all(), 'barang_id', 'nama_barang'),
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                    ],
                                ])->label(false);
                                ?>
                            </td>
                            <td>
                                <?= $form->field($modelBom, "[$i]qty_per_unit")->textInput()->label(false) ?>
                            </td>
                            <td>
                                <?= $form->field($modelBom, "[$i]unit_id")->dropDownList($dataSatuan, ['prompt' => 'Satuan'])->label(false) ?>
                            </td>
                            <td class="text-center vcenter">
                                <button type="button" class="remove-item btn btn-danger btn-xs"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php DynamicFormWidget::end(); ?>
        </div>

        <div class="card-footer">
            <?= Html::submitButton('Simpan BOM', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
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

$this->registerJs($js, View::POS_READY);
?>