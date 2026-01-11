<?php

use app\models\Workcenter;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Mesin $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="mesin-form">
    <div class="card table-card">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="card-body mx-4">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'nama_mesin')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'workcenter_id')
                ->dropDownList(
                    ArrayHelper::map(Workcenter::find()->all(), 'workcenter_id', 'nama_workcenter'),
                    [
                        'prompt' => 'Pilih Workcenter',
                        'clas' => 'form-control',
                    ]
                ) ?>
            <?= $form->field($model, 'kode_mesin')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'status_mesin')
                ->dropDownList([
                    '0' => 'Available',
                    '1' => 'On-Work',
                    '2' => 'Maintenance',
                ], [
                    'prompt' => 'Pilih ketersedian mesin...',
                    'class' => 'form-control'
                ]) ?>
            <?= $form->field($model, 'max_kapasitas_operasi_hari')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'tipe_mesin')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'deskripsi')->textInput(['maxlength' => true]) ?>
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Back', ['mesin/index'], ['class' => 'btn btn-secondary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>

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