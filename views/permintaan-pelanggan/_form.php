<?php

use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
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

            <?= $form->field($model, 'nama_pelanggan')->textInput() ?>

            <?= $form->field($model, 'tanggal_permintaan')->input("date") ?>
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
                        <th style="width: 50%;">Barang</th>
                        <th style="width: 25%;">Jumlah</th>
                        <th style="width: 10%; text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="container-items">
                    <?php foreach ($modelDetails as $i => $detail): ?>
                        <tr class="item">
                            <td>
                                <?= $form->field($detail, "[{$i}]barang_id", ['template' => "{input}\n{error}"])
                                    ->dropDownList(
                                        \yii\helpers\ArrayHelper::map(\app\models\Barang::find()->where(['tipe_barang' => 2])->all(), 'barang_id', 'nama_barang'),
                                        ['prompt' => 'Pilih Barang']
                                    ) ?>
                            </td>
                            <td>
                                <?= $form->field($detail, "[{$i}]jumlah", ['template' => "{input}\n{error}"])
                                    ->textInput(['type' => 'number', 'min' => 1]) ?>
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
                <?= Html::a('Back', 'index', ['class' => 'btn btn-secondary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>