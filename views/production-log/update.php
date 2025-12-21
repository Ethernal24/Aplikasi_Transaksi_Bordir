<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ProductionLog $model */

$this->title = 'Update Production Log: ' . $model->production_log_id;
$this->params['breadcrumbs'][] = ['label' => 'Production Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->production_log_id, 'url' => ['view', 'production_log_id' => $model->production_log_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="production-log-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
