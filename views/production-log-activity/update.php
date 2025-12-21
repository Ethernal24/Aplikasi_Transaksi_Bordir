<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ProductionLogActivity $model */

$this->title = 'Update Production Log Activity: ' . $model->activity_id;
$this->params['breadcrumbs'][] = ['label' => 'Production Log Activities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->activity_id, 'url' => ['view', 'activity_id' => $model->activity_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="production-log-activity-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
