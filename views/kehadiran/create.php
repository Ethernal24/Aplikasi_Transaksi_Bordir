<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Kehadiran $model */

$this->title = 'Create Kehadiran';
$this->params['breadcrumbs'][] = ['label' => 'Kehadirans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kehadiran-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>