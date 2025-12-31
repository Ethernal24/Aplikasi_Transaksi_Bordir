<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Mps $model */

$this->title = 'Buat Mps';
$this->params['breadcrumbs'][] = ['label' => 'Mps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pc-content">
    <?= $this->render('_form', [
        'model' => $model,
        'modelDetails' => $modelDetails,
    ]) ?>

</div>