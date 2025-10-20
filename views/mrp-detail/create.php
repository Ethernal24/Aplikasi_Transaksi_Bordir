<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\MrpDetail $model */

$this->title = 'Create Mrp Detail';
$this->params['breadcrumbs'][] = ['label' => 'Mrp Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mrp-detail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
