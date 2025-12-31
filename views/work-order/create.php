<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\WorkOrder $model */

$this->title = 'Create Work Order';
$this->params['breadcrumbs'][] = ['label' => 'Work Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-order-create">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>