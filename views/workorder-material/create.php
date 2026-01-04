<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\WorkorderMaterial $model */

$this->title = 'Create Workorder Material';
$this->params['breadcrumbs'][] = ['label' => 'Workorder Materials', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="workorder-material-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
