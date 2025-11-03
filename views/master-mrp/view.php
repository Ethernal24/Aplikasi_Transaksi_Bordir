<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\MasterMrp $model */
/** @var app\models\MrpDetailSearch $searchModel */

$this->title = 'Detail MRP : ' . $model->mrp_id;
$this->params['breadcrumbs'][] = ['label' => 'Master Mrps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pc-content">
    <div class="card card-table">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="row mx-3">
            <div class="col">
                <div>
                    <strong>Nama Barang : </strong>
                    <?= $model->mps->barangName ?>
                </div>
                <div>
                    <strong>Tipe : </strong>
                    <?= $model->mps->tipeLabel ?>
                </div>
            </div>
        </div>


        <div class="card-body">
            <div class="table-responsive">
                <?= GridView::widget([
                    'dataProvider' => new \yii\data\ArrayDataProvider([
                        'allModels' => $details,
                        'pagination' => false,
                        'sort' => [
                            'attributes' => [
                                'barang_id',
                                'minggu_ke',
                            ],
                            'defaultOrder' => ['barang_id' => SORT_DESC],
                        ]
                    ]),
                    'columns' => [
                        [
                            'attribute' => 'barang_id',
                            'value' => function ($model) {
                                return $model->barang->nama_barang;
                            },
                            'label' => 'Nama Produk',

                        ],
                        [
                            'attribute' => 'minggu_ke',
                            'value' => 'minggu_ke',
                            'label' => 'Minggu Ke',
                        ],
                        [
                            'attribute' => 'kebutuhan_kotor',
                            'value' => 'kebutuhan_kotor',
                            'label' => 'Kebutuhan Kotor',
                        ],
                        [
                            'attribute' => 'stok_tersedia',
                            'value' => function ($model) {
                                return $model->barang->stok;
                            },
                            'label' => 'Stok Tersedia',
                        ],
                        [
                            'attribute' => 'kebutuhan_bersih',
                            'value' => 'kebutuhan_bersih',
                            'label' => 'Kebutuhan Bersih',
                        ],
                        [
                            'attribute' => 'leadtime',
                            'value' => 'leadtime',
                            'label' => 'Leadtime',
                        ],
                        [
                            'attribute' => 'planned_order_release',
                            'value' => 'planned_order_release',
                            'label' => 'Planned Order Release',
                        ],
                        [
                            'attribute' => 'planned_order_receipt',
                            'value' => 'planned_order_receipt',
                            'label' => 'Planned Order Receipt',
                        ],
                        [
                            'attribute' => 'unit_id',
                            'value' => function ($model) {
                                return $model->barang->unit->satuan;
                            },
                            'label' => 'Satuan',
                        ],
                    ],
                ]); ?>

            </div>
            <?= Html::a('Update', ['update', 'mrp_id' => $model->mrp_id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'mrp_id' => $model->mrp_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
            <?= Html::a('Back', ['index'], ['class' => 'btn btn-secondary']) ?>
        </div>
    </div>


    <p>

    </p>


</div>