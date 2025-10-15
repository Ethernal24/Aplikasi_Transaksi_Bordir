<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\BomCustom $models */

$this->title = 'Update Bom Custom: ' . $models[0]->permintaan_detail_id;
$this->params['breadcrumbs'][] = ['label' => 'Bom Customs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $models[0]->permintaan_detail_id, 'url' => ['view', 'permintaan_detail_id' => $models[0]->permintaan_detail_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pc-content">

    <?= $this->render('_form_multiple', [
        'models' => $models,
    ]) ?>

</div>