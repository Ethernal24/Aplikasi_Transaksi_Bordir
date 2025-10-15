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
/** @var app\models\Barang $modelBarangmodel */
/** @var yii\widgets\ActiveForm $form */
/** @var yii\data\ActiveDataProvider $dataProvider */


?>

<div class="barang-form">
    <div class="card table-card">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
            <!-- Tombol Consumable dan Non Consumable -->
        </div>

        <div class="card-body mx-4">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($modelBarang, 'kode_barang')->textInput(['maxlength' => true]) ?>

            <?= $form->field($modelBarang, 'nama_barang')->textInput(['maxlength' => true]) ?>

            <?= $form->field($modelBarang, 'jenis')->label('Jenis')->dropDownList([
                0 => 'Beli',
                1 => 'Produksi',
            ]) ?>
            <?= $form->field($modelBarang, 'unit_id')->dropDownList(
                ArrayHelper::map(Unit::find()->asArray()->all(), 'unit_id', 'satuan'),
                ['prompt' => 'Pilih Satuan']
            ) ?>

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
            <?= $form->field($modelBarang, 'leadtime')->textInput(['maxlength' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Back', [$backUrl], ['class' => 'btn btn-secondary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>