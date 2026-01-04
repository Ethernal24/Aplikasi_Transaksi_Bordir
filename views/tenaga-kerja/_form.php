<?php

use app\models\Workcenter;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TenagaKerja $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="pc-content">
    <div class="card table-card">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="card-body mx-4">
            <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'nama')->textInput() ?>
            <?= $form->field($model, 'workcenter_id')->dropDownList(
                ArrayHelper::map(Workcenter::find()->all(), 'workcenter_id', 'nama_workcenter'),
                [
                    'prompt' => 'Pilih Workcenter...'
                ]
            ) ?>
            <?= $form->field($model, 'jabatan')->textInput() ?>
            <?= $form->field($model, 'kemampuan')->textInput() ?>
            <?= $form->field($model, 'status_kerja')->dropDownList(
                [
                    0 => 'Available',
                    1 => 'Off',
                ],
                [
                    'prompt' => 'Pilih Status....'
                ]
            ) ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Back', 'index', ['class' => 'btn btn-secondary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>