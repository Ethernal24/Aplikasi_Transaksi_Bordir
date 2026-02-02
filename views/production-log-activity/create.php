<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ProductionLogActivity $model */

$this->title = 'Create Production Log Activity';
$this->params['breadcrumbs'][] = ['label' => 'Production Log Activities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="production-log-activity-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'routingDetail' => $routingDetail,
        'sisaReal' => $sisaReal,
    ]) ?>

</div>