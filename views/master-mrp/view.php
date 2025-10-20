<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\MasterMrp $model */

$this->title = $model->mrp_id;
$this->params['breadcrumbs'][] = ['label' => 'Master Mrps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="master-mrp-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'mrp_id' => $model->mrp_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'mrp_id' => $model->mrp_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'mrp_id',
            'mps_id',
            'status',
        ],
    ]) ?>

</div>
