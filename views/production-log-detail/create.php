<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ProductionLogDetail $model */

$this->title = 'Create Production Log Detail';
$this->params['breadcrumbs'][] = ['label' => 'Production Log Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="production-log-detail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
