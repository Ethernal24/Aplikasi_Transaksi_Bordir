<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TenagaKerja $model */

$this->title = 'Tambahkan Karyawan';
$this->params['breadcrumbs'][] = ['label' => 'Tenaga Kerjas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pc-content">
    <?= $this->render('_form', [
        'modelTenagas' => $modelTenagas,
    ]) ?>

</div>