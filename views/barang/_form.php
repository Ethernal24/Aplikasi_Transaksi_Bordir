<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Barang $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="barang-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kode_barang')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nama_barang')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'angka')->textInput(['maxlength' => true]) ?>

    <?php
    $dataPost = ArrayHelper::map(\app\models\Unit::find()->asArray()->all(), 'unit_id', function ($model) {
        return $model['unit_id'] . ' - ' . $model['satuan'];
    });
    echo $form->field($model, 'unit_id')
        ->dropDownList(
            $dataPost,
            ['prompt' => 'Satuan', 'unit_id' => 'unit_id']
        );
    ?>

    <?= $form->field($model, 'harga')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tipe')->dropDownList(
        [
            'prompt' => 'Pilih Tipe',
            "Consumable" => 'Consumable',
            "Non Consumable" => 'Non Consumable',
        ]
    ); ?>

    <!-- <?= $form->field($model, 'tipe')->textInput(['maxlength' => true]) ?> -->

    <?= $form->field($model, 'warna')->textInput(['maxlength' => true]) ?>

    <?php
    $dataPost = ArrayHelper::map(\app\models\Supplier::find()->asArray()->all(), 'supplier_id', function ($model) {
        return $model['supplier_id'] . ' - ' . $model['nama'];
    });
    echo $form->field($model, 'supplier_id')
        ->dropDownList(
            $dataPost,
            ['prompt' => 'Pilih Supplier', 'supplier_id' => 'supplier_id']
        );
    ?>

    <!-- <?= $form->field($model, 'created_at')->textInput() ?> -->

    <!-- <?= $form->field($model, 'updated_at')->textInput() ?> -->

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Back', ['barang/index'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>