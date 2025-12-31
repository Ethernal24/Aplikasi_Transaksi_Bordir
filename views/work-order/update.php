<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\WorkOrder $model */

$this->title = 'Update Work Order: ' . $model->id_wo;
$this->params['breadcrumbs'][] = ['label' => 'Work Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_wo, 'url' => ['view', 'id_wo' => $model->id_wo]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="work-order-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>