<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Kehadiran $model */

$this->title = 'Update Kehadiran: ' . $model->kehadiran_id;
$this->params['breadcrumbs'][] = ['label' => 'Kehadirans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->kehadiran_id, 'url' => ['view', 'kehadiran_id' => $model->kehadiran_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="kehadiran-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
