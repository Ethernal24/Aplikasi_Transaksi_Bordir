<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\BomCustom $model */

$this->title = 'Update Bom Custom: ' . $model->bom_custom_id;
$this->params['breadcrumbs'][] = ['label' => 'Bom Customs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->bom_custom_id, 'url' => ['view', 'bom_custom_id' => $model->bom_custom_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pc-content">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>