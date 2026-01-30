<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\MpsDetailAllocation $model */

$this->title = 'Update Mps Detail Allocation: ' . $model->mps_detail_allocation_id;
$this->params['breadcrumbs'][] = ['label' => 'Mps Detail Allocations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->mps_detail_allocation_id, 'url' => ['view', 'mps_detail_allocation_id' => $model->mps_detail_allocation_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mps-detail-allocation-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
