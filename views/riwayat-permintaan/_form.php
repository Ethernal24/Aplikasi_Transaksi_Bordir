<?php

use app\models\Barang;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\RiwayatPermintaan $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="riwayat-permintaan-form">
    <div class="card table-card">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="card-body mx-4">
            <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
            <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper',
                'widgetBody' => '.container-items',
                'widgetItem' => '.item',
                'limit' => 20,
                'min' => 1,
                'insertButton' => '.add-item',
                'deleteButton' => '.remove-item',
                'model' => $model,
                'formId' => 'dynamic-form',
                'formFields' => ['barang_id', 'bulan', 'tahun', 'jumlah_permintaan']
            ]); ?>


            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="width: 30%;">Barang</th>
                        <th style="width: 20%;">Bulan</th>
                        <th style="width: 20%;">Tahun</th>
                        <th style="width: 20%;">Jumlah Permintaan</th>
                        <th style="width: 10%; text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="container-items">
                    <tr class="item">
                        <td>
                            <?= Html::dropDownList(
                                'barang_id[]',
                                null,
                                ArrayHelper::map(
                                    Barang::find()->where(['tipe_barang' => 2])->all(),
                                    'barang_id',
                                    'nama_barang'
                                ),
                                ['prompt' => 'Pilih Barang', 'class' => 'form-control']
                            ) ?>
                        </td>
                        <td>
                            <?= Html::dropDownList(
                                'bulan[]',
                                null,
                                [
                                    '1' => 'Januari',
                                    '2' => 'Februari',
                                    '3' => 'Maret',
                                    '4' => 'April',
                                    '5' => 'Mei',
                                    '6' => 'Juni',
                                    '7' => 'Juli',
                                    '8' => 'Agustus',
                                    '9' => 'September',
                                    '10' => 'Oktober',
                                    '11' => 'November',
                                    '12' => 'Desember',
                                ],
                                ['prompt' => 'Pilih Bulan', 'class' => 'form-control']
                            ) ?>
                        </td>
                        <td>
                            <?= Html::textInput('tahun[]', date('Y'), [
                                'class' => 'form-control',
                                'type' => 'number',
                                'min' => 2000
                            ]) ?>
                        </td>
                        <td>
                            <?= Html::textInput('jumlah[]', '', [
                                'class' => 'form-control',
                                'type' => 'number',
                                'min' => 1
                            ]) ?>
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
                </tbody>
            </table>

            <?php DynamicFormWidget::end(); ?>
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Back', 'index', ['class' => 'btn btn-secondary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>


</div>