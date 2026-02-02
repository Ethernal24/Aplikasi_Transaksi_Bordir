<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\JadwalSimulasi $model */

$this->title = 'Update Jadwal Simulasi: ' . $model->simulasi_id;
$this->params['breadcrumbs'][] = ['label' => 'Jadwal Simulasis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->simulasi_id, 'url' => ['view', 'simulasi_id' => $model->simulasi_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="jadwal-simulasi-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>