<?php

use app\models\MpsDetailAllocation;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\MpsDetailAllocationSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Mps Detail Allocations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mps-detail-allocation-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Mps Detail Allocation', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'mps_detail_allocation_id',
            'mps_detail_id',
            'workcenter_id',
            'qty_mesin_alokasi',
            'qty_karyawan_alokasi',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, MpsDetailAllocation $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'mps_detail_allocation_id' => $model->mps_detail_allocation_id]);
                 }
            ],
        ],
    ]); ?>


</div>
