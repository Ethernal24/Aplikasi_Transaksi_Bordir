<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Workcenter $model */

$this->title = 'Create Workcenter';
$this->params['breadcrumbs'][] = ['label' => 'Workcenters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pc-content">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>