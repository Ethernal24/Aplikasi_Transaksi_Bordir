<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Unit $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Units', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pc-content">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <h1>Informasi Unit</h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nama',
        ],
    ]) ?>

    <div>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Back', ['unit/index'], ['class' => 'btn btn-secondary']) ?>
    </div>

</div>
