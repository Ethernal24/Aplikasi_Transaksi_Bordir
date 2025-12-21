<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ProductionLog $model */

$this->title = 'Create Production Log';
$this->params['breadcrumbs'][] = ['label' => 'Production Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pc-content">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>