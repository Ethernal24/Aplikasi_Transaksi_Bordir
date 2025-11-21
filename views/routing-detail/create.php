<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\RoutingDetail $model */

$this->title = 'Create Routing Detail';
$this->params['breadcrumbs'][] = ['label' => 'Routing Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="routing-detail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
