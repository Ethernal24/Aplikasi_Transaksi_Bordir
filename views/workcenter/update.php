<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Workcenter $model */

$this->title = 'Update Workcenter: ' . $model->workcenter_id;
$this->params['breadcrumbs'][] = ['label' => 'Workcenters', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->workcenter_id, 'url' => ['view', 'workcenter_id' => $model->workcenter_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pc-content">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>