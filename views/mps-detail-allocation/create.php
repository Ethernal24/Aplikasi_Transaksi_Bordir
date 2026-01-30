<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\MpsDetailAllocation $model */

$this->title = 'Create Mps Detail Allocation';
$this->params['breadcrumbs'][] = ['label' => 'Mps Detail Allocations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mps-detail-allocation-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
