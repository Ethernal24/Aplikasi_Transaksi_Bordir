<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\WoHeader $model */

$this->title = 'Create Wo Header';
$this->params['breadcrumbs'][] = ['label' => 'Wo Headers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wo-header-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
