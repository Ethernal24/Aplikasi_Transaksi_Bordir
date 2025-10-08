<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\RiwayatPermintaan $model */

$this->title = 'Update Riwayat Permintaan: ' . $model->riwayat_id;
$this->params['breadcrumbs'][] = ['label' => 'Riwayat Permintaans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->riwayat_id, 'url' => ['view', 'riwayat_id' => $model->riwayat_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pc-content">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>