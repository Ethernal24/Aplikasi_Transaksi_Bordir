<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\MasterMrp $model */
/** @var app\models\MrpDetailSearch $searchModel */

$this->title = 'Detail MRP : ' . $model->kode_mrp;
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
                <span><strong>Kode MPS :</strong> <?= $model->mps->kode_mps ?></span>
            </div>
            <div class="col">
                <div><strong>Status MRP :</strong>
                    <span class="<?= $model->getLabel()['class'] ?>"><?= $model->getLabel()['label'] ?></span>
                </div>
            </div>
            <div class="col">

            </div>
        </div>


        <div class="card-body">
            <div class="table-responsive">
                <?= GridView::widget([
                    'dataProvider' => new \yii\data\ArrayDataProvider([
                        'allModels' => $details,
                        'pagination' => false,
                    ]),
                    'columns' => [
                        [
                            'attribute' => 'produk_id',
                            'value' => function ($model) {
                                return $model->produk->nama_barang ?? '-';
                            },
                            'label' => 'Nama Produk',
                        ],
                        [
                            'attribute' => 'bahan_id',
                            'label' => 'Nama Bahan',
                            'value' => function ($model) {
                                return $model->bahan->nama_barang;
                            },
                        ],
                        [
                            'attribute' => 'kebutuhan_kotor',
                            'value' => 'kebutuhan_kotor',
                            'label' => 'Kebutuhan Kotor',
                        ],
                        [
                            'attribute' => 'stok_tersedia',
                            'value' => function ($model) {
                                return $model->stock_tersedia ?? 0;
                            },
                            'label' => 'Stok Tersedia',
                        ],
                        [
                            'attribute' => 'kebutuhan_bersih',
                            'value' => 'kebutuhan_bersih',
                            'label' => 'Kebutuhan Bersih',
                        ],
                        // [
                        //     'attribute' => 'unit_id',
                        //     'value' => function ($model) {
                        //         return $model->barang->unit->satuan;
                        //     },
                        //     'label' => 'Satuan',
                        // ],
                    ],
                ]); ?>

            </div>
            <!-- <?= Html::a('Update', ['update', 'mrp_id' => $model->mrp_id], ['class' => 'btn btn-primary']) ?> -->
            <?php if ($model->status === 0): ?>
                <?= Html::a('Validasi', ['validasi', 'mrp_id' => $model->mrp_id], [
                    'class' => 'btn btn-warning',
                    'data' => [
                        'confirm' => 'Yakin ingin memvalidasi MRP ini?'
                    ]
                ]) ?>
            <?php endif; ?>
            <?= Html::a('Back', ['index'], ['class' => 'btn btn-secondary']) ?>
        </div>
    </div>


    <p>

    </p>


</div>