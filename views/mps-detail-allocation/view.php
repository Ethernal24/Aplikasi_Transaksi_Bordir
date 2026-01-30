<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\MpsDetailAllocation $model */

$this->title = $model->mps_detail_allocation_id;
$this->params['breadcrumbs'][] = ['label' => 'Mps Detail Allocations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="mps-detail-allocation-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'mps_detail_allocation_id' => $model->mps_detail_allocation_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'mps_detail_allocation_id' => $model->mps_detail_allocation_id], [
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
            'mps_detail_allocation_id',
            'mps_detail_id',
            'workcenter_id',
            'qty_mesin_alokasi',
            'qty_karyawan_alokasi',
        ],
    ]) ?>

</div>
