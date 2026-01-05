<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ProductionLogAttendance $model */

$this->title = 'Create Production Log Attendance';
$this->params['breadcrumbs'][] = ['label' => 'Production Log Attendances', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="production-log-attendance-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
