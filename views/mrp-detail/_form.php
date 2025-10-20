<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\MrpDetail $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="mrp-detail-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'mrp_id')->textInput() ?>

    <?= $form->field($model, 'bahan_id')->textInput() ?>

    <?= $form->field($model, 'kebutuhan_kotor')->textInput() ?>

    <?= $form->field($model, 'stock_tersedia')->textInput() ?>

    <?= $form->field($model, 'kebutuhan_bersih')->textInput() ?>

    <?= $form->field($model, 'leadtime')->textInput() ?>

    <?= $form->field($model, 'planned_order_release')->textInput() ?>

    <?= $form->field($model, 'planned_order_receipt')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
