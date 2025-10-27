<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\MpsDetail $model */

$this->title = 'Update Mps Detail: ' . $model->mps_detail_id;
$this->params['breadcrumbs'][] = ['label' => 'Mps Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->mps_detail_id, 'url' => ['view', 'mps_detail_id' => $model->mps_detail_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mps-detail-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
