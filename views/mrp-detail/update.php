<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\MrpDetail $model */

$this->title = 'Update Mrp Detail: ' . $model->mrp_detail_id;
$this->params['breadcrumbs'][] = ['label' => 'Mrp Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->mrp_detail_id, 'url' => ['view', 'mrp_detail_id' => $model->mrp_detail_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mrp-detail-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
