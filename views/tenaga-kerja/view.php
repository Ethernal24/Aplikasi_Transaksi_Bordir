<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\TenagaKerja $model */

$this->title = $model->tk_id;
$this->params['breadcrumbs'][] = ['label' => 'Tenaga Kerjas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tenaga-kerja-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'tk_id' => $model->tk_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'tk_id' => $model->tk_id], [
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
            'tk_id',
            'nama',
            'jabatan',
            'kemampuan',
            'status_kerja',
            'dibuat_pada',
            'diupdate_pada',
        ],
    ]) ?>

</div>