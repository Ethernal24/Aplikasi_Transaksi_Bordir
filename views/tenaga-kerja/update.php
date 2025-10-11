<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TenagaKerja $model */

$this->title = 'Update Tenaga Kerja: ' . $model->tk_id;
$this->params['breadcrumbs'][] = ['label' => 'Tenaga Kerjas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tk_id, 'url' => ['view', 'tk_id' => $model->tk_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tenaga-kerja-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'modelTenagas' => $modelTenagas,
    ]) ?>

</div>