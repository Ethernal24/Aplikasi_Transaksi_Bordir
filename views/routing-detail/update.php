<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\RoutingDetail $model */

$this->title = 'Update Routing Detail: ' . $model->routing_detail_id;
$this->params['breadcrumbs'][] = ['label' => 'Routing Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->routing_detail_id, 'url' => ['view', 'routing_detail_id' => $model->routing_detail_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="routing-detail-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
