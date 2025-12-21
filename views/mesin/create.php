<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Mesin $model */

$this->title = 'Create Mesin';
$this->params['breadcrumbs'][] = ['label' => 'Mesins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pc-content">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>