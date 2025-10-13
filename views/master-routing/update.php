<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\MasterRouting $model */

$this->title = 'Update Master Routing: ' . $model->routing_id;
$this->params['breadcrumbs'][] = ['label' => 'Master Routings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->routing_id, 'url' => ['view', 'routing_id' => $model->routing_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="master-routing-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
