<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\BomCustom $model */

$this->title = $model->bom_custom_id;
$this->params['breadcrumbs'][] = ['label' => 'Bom Customs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="bom-custom-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'bom_custom_id' => $model->bom_custom_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'bom_custom_id' => $model->bom_custom_id], [
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
            'bom_custom_id',
            'permintaan_detail_id',
            'bahan_id',
            'qty_per_unit',
            'unit_id',
            'catatan',
        ],
    ]) ?>

</div>
