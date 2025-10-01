<?php

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
    </div>
    <div class="card-body mx-4">

        <?php $form = ActiveForm::begin(); ?>
    
        <?= $form->field($model, 'jumlah')->textInput() ?>
    
        <?= $form->field($model, 'tanggal_permintaan')->textInput() ?>
    
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>
    
        <?php ActiveForm::end(); ?>
    </div>

</div>
