<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Workcenter $model */

$this->title = $model->workcenter_id;
$this->params['breadcrumbs'][] = ['label' => 'Workcenters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="workcenter-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'workcenter_id' => $model->workcenter_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'workcenter_id' => $model->workcenter_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Back', 'index', ['class' => 'btn btn-secondary']) ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'workcenter_id',
            'kode_workcenter',
            'nama_workcenter',
            'tipe_kapasitas',
            'tk_id',
            'keterangann',
        ],
    ]) ?>

</div>