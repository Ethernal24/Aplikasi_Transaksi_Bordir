<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Gudang $model */

$this->title = 'Create Gudang';
$this->params['breadcrumbs'][] = ['label' => 'Gudangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gudang-create">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>