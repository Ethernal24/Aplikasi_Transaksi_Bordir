<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Pembelian $model */

$this->title = $model->pembelian_id;
$this->params['breadcrumbs'][] = ['label' => 'Pembelians', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pc-content">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'pembelian_id' => $model->pembelian_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'pembelian_id' => $model->pembelian_id], [
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
            'pembelian_id',
            'pemesanan_id',
            'user_id',
            'total_biaya',
        ],
    ]) ?>

</div>