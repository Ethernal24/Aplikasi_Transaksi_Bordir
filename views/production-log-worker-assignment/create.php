<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ProductionLogWorkerAssignment $model */

$this->title = 'Buat Jadwal Shift';
$this->params['breadcrumbs'][] = ['label' => 'Production Log Worker Assignments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="production-log-worker-assignment-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>