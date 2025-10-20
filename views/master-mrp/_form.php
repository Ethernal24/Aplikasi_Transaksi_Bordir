<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\MasterMrp $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="master-mrp-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'mps_id')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
