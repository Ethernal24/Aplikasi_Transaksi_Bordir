<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\WorkorderMaterial $model */

$this->title = 'Update Workorder Material: ' . $model->wo_mat_id;
$this->params['breadcrumbs'][] = ['label' => 'Workorder Materials', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->wo_mat_id, 'url' => ['view', 'wo_mat_id' => $model->wo_mat_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="workorder-material-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
