<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ProductionLogDowntime $model */

$this->title = 'Update Production Log Downtime: ' . $model->downtime_id;
$this->params['breadcrumbs'][] = ['label' => 'Production Log Downtimes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->downtime_id, 'url' => ['view', 'downtime_id' => $model->downtime_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="production-log-downtime-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
