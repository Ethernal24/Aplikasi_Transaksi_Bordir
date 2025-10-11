<?php

use app\models\Bom;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\BomSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Boms';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pc-content">
    <div class="card table-card">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
            <?= Html::a('Create Bom', ['create'], ['class' => 'btn btn-success']) ?>
        </div>

        <div class="card-body mx-4">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    // 'bom_id'=>,
                    'produk_id' => [
                        'attribute' => 'produk_id',
                        'value' => 'produk.nama_barang',
                        'label' => 'Nama Produk',
                    ],
                    'bahan_id' => [
                        'attribute' => 'bahan_id',
                        'value' => 'bahan.nama_barang',
                        'label' => 'Nama Bahan',
                    ],
                    'qty_per_unit',
                    'unit_id' => [
                        'attribute' => 'unit_id',
                        'value' => 'unit.satuan',
                        'label' => 'Satuan',
                    ],
                    [
                        'class' => ActionColumn::className(),
                        'urlCreator' => function ($action, Bom $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'bom_id' => $model->bom_id]);
                        }
                    ],
                ],
            ]); ?>
        </div>
    </div>



</div>