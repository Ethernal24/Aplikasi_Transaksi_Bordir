<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Bom $model */

$this->title = $model->bom_id;
$this->params['breadcrumbs'][] = ['label' => 'Boms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pc-content">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'bom_id' => $model->bom_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'bom_id' => $model->bom_id], [
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
            'bom_id',
            'produk_id',
            'bahan_id',
            'qty_per_unit',
            'unit_id',
        ],
    ]) ?>

</div>