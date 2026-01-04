<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ProductionLogWorkerAssignment $model */

$this->title = 'Update Jadwal Harian  ';
$this->params['breadcrumbs'][] = ['label' => 'Production Log Worker Assignments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_assignment, 'url' => ['view', 'id_assignment' => $model->id_assignment]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="production-log-worker-assignment-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>