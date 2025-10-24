<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Mps $model */

$this->title = 'Update Mps: ' . $model->mps_id;
$this->params['breadcrumbs'][] = ['label' => 'Mps', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->mps_id, 'url' => ['view', 'mps_id' => $model->mps_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pc-content">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>