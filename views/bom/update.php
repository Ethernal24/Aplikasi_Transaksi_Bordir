<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Bom $model */

$this->title = 'Update Bom: ' . $model->bom_id;
$this->params['breadcrumbs'][] = ['label' => 'Boms', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->bom_id, 'url' => ['view', 'bom_id' => $model->bom_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="bom-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
