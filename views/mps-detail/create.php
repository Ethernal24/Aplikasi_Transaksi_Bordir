<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\MpsDetail $model */

$this->title = 'Create Mps Detail';
$this->params['breadcrumbs'][] = ['label' => 'Mps Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mps-detail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
