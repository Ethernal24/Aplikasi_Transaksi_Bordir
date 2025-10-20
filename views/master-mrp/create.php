<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\MasterMrp $model */

$this->title = 'Create Master Mrp';
$this->params['breadcrumbs'][] = ['label' => 'Master Mrps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-mrp-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
