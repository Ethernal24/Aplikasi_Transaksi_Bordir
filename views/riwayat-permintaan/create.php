<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\RiwayatPermintaan $model */

$this->title = 'Create Riwayat Permintaan';
$this->params['breadcrumbs'][] = ['label' => 'Riwayat Permintaans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pc-content">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>