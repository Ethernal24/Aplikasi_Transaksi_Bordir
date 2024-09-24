<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\LaporanKeluar $model */

$this->title = 'Update Laporan Keluar: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Laporan Keluars', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pc-content">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
