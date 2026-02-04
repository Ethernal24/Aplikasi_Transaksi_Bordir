<?php

use app\models\Mesin;
use app\models\Shift;
use app\models\TenagaKerja;
use app\models\Workcenter;
use app\models\Workorder;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ProductionLogWorkerAssignment $model */
/** @var yii\widgets\ActiveForm $form */
?>
<style>
    /* Membuat tanggal yang disabled berwarna merah pudar dan dicoret */
    .datepicker table tr td.disabled,
    .datepicker table tr td.disabled:hover {
        color: #ff0000 !important;
        text-decoration: line-through;
        background-color: #f8f9fa !important;
        cursor: not-allowed !important;
    }
</style>
<div class="pc-content">
    <div class="card table-card">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="card-body mx-4">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'tanggal_assignment')->widget(DatePicker::class, [
                'options' => [
                    'placeholder' => 'Pilih tanggal...',
                    'autocomplete' => 'off', // Tambahkan ini agar tidak tertutup history browser
                ],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true,
                    // Tambahkan startDate agar tanggal sebelum hari ini otomatis mati
                    'startDate' => date('Y-m-d'),
                ],
            ]) ?>

            <?= $form->field($model, 'id_tk')->dropDownList(
                ArrayHelper::map(TenagaKerja::find()->all(), 'tk_id', 'nama'),
                [
                    'prompt' => 'Pilih Tenaga Kerja...',
                ]
            )->label('Tenaga Kerja') ?>

            <?= $form->field($model, 'id_mesin')->dropDownList(
                ArrayHelper::map(Mesin::find()->all(), 'id_mesin', 'nama_mesin'),
                [
                    'prompt' => 'Pilih Mesin...',
                ]
            )->label('Mesin') ?>

            <?= $form->field($model, 'id_workcenter')->dropDownList(
                ArrayHelper::map(Workcenter::find()->all(), 'workcenter_id', 'nama_workcenter'),
                [
                    'prompt' => 'Pilih Workcenter...',
                ]
            )->label('Work Center') ?>

            <?= $form->field($model, 'id_shift')->dropDownList(
                ArrayHelper::map(Shift::find()->all(), 'shift_id', 'nama_shift'),
                [
                    'prompt' => 'Pilih Shift...',
                ]
            )->label('Shift') ?>

            <?= $form->field($model, 'id_wo')->dropDownList(
                ArrayHelper::map(Workorder::find()->all(), 'id_wo', 'kode_wo'),
                [
                    'prompt' => 'Pilih Workorder...',
                ]
            )->label('Work Order') ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Back', 'index', ['class' => 'btn btn-secondary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>




</div>