<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\WoHeader $model */

$this->title = 'Update Wo Header: ' . $model->wo_id;
$this->params['breadcrumbs'][] = ['label' => 'Wo Headers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->wo_id, 'url' => ['view', 'wo_id' => $model->wo_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="wo-header-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
