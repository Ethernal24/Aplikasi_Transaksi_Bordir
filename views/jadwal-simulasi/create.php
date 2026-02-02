<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\JadwalSimulasi $model */

$this->title = 'Create Jadwal Simulasi';
$this->params['breadcrumbs'][] = ['label' => 'Jadwal Simulasis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jadwal-simulasi-create">



    <?= $this->render('_form', [
        'model' => $model,
        'disabledDates' => $disabledDates
    ]) ?>

</div>