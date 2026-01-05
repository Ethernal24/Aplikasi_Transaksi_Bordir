<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\ProductionLogWorkerAssignment $model */

$this->title = $model->id_assignment;
$this->params['breadcrumbs'][] = ['label' => 'Production Log Worker Assignments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="production-log-worker-assignment-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_assignment' => $model->id_assignment], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_assignment' => $model->id_assignment], [
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
            'id_assignment',
            'tanggal_assignment',
            'id_tk',
            'id_workcenter',
            'id_shift',
            'id_wo',
        ],
    ]) ?>

</div>
