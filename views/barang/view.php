<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Barang $model */

$this->title = 'BOM : ' . $model->nama_barang;
$this->params['breadcrumbs'][] = ['label' => 'Barangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pc-content">
    <div class="card card-table">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="row mx-3">
            <div class="col-md-3">
                <div><strong>Kode barang : </strong> <?= $model->kode_barang ?></div>
                <div><strong>Nama barang : </strong> <?= $model->nama_barang ?></div>
            </div>
            <div class="col-md-3">
                <div><strong>Jenis : </strong> <?= $model->jenisLabel ?></div>
                <div><strong>stok : </strong> <?= $model->stok ?></div>
            </div>
            <div class="col-md-3">
                <div><strong>leadtime : </strong> <?= $model->leadtime ?> hari</div>
                <div><strong>Tipe barang : </strong> <?= $model->tipeLabel ?></div>
            </div>
            <div class="col-md-3">
                <div><strong>satuan : </strong> <?= $model->unit->satuan ?></div>
            </div>
        </div>
        <hr>
        <div class="card-body">
            <div class="table-responsive">
                <?= GridView::widget([
                    'dataProvider' => new \yii\data\ArrayDataProvider([
                        'allModels' => $bom,
                        'pagination' => false, // Sesuaikan jika tidak menggunakan pagination
                    ]),
                    // Harus menunjukkan 5 jika terdapat 5 data
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn', 'header' => 'No'],
                        // 'produk_id',
                        'bahan_id' => [
                            'attribute' => 'bahan_id',
                            'value' => 'bahan.nama_barang',
                            'label' => 'Nama Bahan'
                        ],
                        'qty_per_unit',
                        'unit_id' => [
                            'attribute' => 'unit_id',
                            'value' => 'unit.satuan',
                            'label' => 'Satuan',
                        ],
                    ],

                ]);
                ?>
                <div class="form-group mb-4">
                    <!-- <?= Html::a('Update', ['update', 'barang_id' => $model->barang_id], ['class' => 'btn btn-success']) ?> -->
                    <?= Html::a('Back', ['index-barang-jadi'], ['class' => 'btn btn-secondary']) ?>
                </div>
            </div>
        </div>
    </div>
    <!-- <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    // 'barang_id',
                    'kode_barang',
                    'nama_barang',
                    'jenis',
                    'stok',
                    'leadtime',
                    'unit.satuan',
                    'tipe_barang',
                    'created_at:datetime',
                    'updated_at:datetime',
                ],
            ]) ?> -->
    <!-- <div>
        <?= Html::a('Update', ['update', 'barang_id' => $model->barang_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'barang_id' => $model->barang_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],

        ]) ?>
        <?= Html::a('Back', ['barang/index'], ['class' => 'btn btn-secondary']) ?>
    </div> -->

</div>