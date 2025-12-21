<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Kehadiran $model */

$this->title = $model->kehadiran_id;
$this->params['breadcrumbs'][] = ['label' => 'Kehadirans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="kehadiran-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'kehadiran_id' => $model->kehadiran_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'kehadiran_id' => $model->kehadiran_id], [
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
            'kehadiran_id',
            'tanggal',
            'tk_id',
            'shift_id',
            'status_kehadiran',
            'jam_masuk_real',
            'jam_pulang_real',
        ],
    ]) ?>

</div>
