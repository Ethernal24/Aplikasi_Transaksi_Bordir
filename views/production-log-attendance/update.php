<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ProductionLogAttendance $model */

$this->title = 'Update Production Log Attendance: ' . $model->attendance_id;
$this->params['breadcrumbs'][] = ['label' => 'Production Log Attendances', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->attendance_id, 'url' => ['view', 'attendance_id' => $model->attendance_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="production-log-attendance-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
