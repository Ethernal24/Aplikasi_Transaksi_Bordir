<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ProductionLogDetail $model */

$this->title = 'Update Production Log Detail: ' . $model->detail_id;
$this->params['breadcrumbs'][] = ['label' => 'Production Log Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->detail_id, 'url' => ['view', 'detail_id' => $model->detail_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="production-log-detail-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
