<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\BomCustom $model */

$this->title = 'Create Bom Custom';
$this->params['breadcrumbs'][] = ['label' => 'Bom Customs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pc-content">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>