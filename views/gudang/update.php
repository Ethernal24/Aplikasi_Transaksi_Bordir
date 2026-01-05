<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Gudang $model */

$this->title = 'Update Gudang: ' . $model->id_gudang;
$this->params['breadcrumbs'][] = ['label' => 'Gudangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_gudang, 'url' => ['view', 'id_gudang' => $model->id_gudang]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="gudang-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>