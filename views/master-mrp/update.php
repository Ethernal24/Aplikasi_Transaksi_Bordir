<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\MasterMrp $model */

$this->title = 'Update Master Mrp: ' . $model->mrp_id;
$this->params['breadcrumbs'][] = ['label' => 'Master Mrps', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->mrp_id, 'url' => ['view', 'mrp_id' => $model->mrp_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="master-mrp-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
