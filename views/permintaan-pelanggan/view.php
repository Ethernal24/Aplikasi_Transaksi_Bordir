<?php

use app\models\PermintaanDetail;
use app\models\PermintaanPelanggan;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\PermintaanPelanggan $model */

$this->title = 'Detail Permintaan Pelanggan : ' . $model->kode_permintaan;
$this->params['breadcrumbs'][] = ['label' => 'Permintaan Pelanggans', 'url' => ['index']];
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
                <div><strong>Kode Permintaan : </strong> <?= $model->kode_permintaan ?></div>
                <div><strong>Nama Pelangga : </strong> <?= $model->nama_pelanggan ?></div>
            </div>
            <div class="col">
                <div><strong>Tanggal Permintaan : </strong> <?= $model->tanggal_permintaan ?></div>
                <div><strong>Tenggat Waktu : </strong> <?= $model->tenggat_waktu ?></div>
            </div>
            <div class="col">
                <div><strong>Status Pesanan : </strong> <?= $model->status_pesanan ?></div>
            </div>
        </div>
        <hr>
        <div class="card-body">
            <div class="table-responsive">
                <h5>Data Produk</h5>
                <?= GridView::widget([
                    'dataProvider' => new \yii\data\ArrayDataProvider([
                        'allModels' => $detail,
                        'pagination' => false, // Sesuaikan jika tidak menggunakan pagination
                    ]),
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn', 'header' => 'No'],

                        [
                            'attribute' => 'barang_id',
                            'value' => 'barang.nama_barang',
                            'label' => 'Nama Barang',
                        ],
                        [
                            'attribute' => 'jumlah',
                            'value' => 'jumlah',
                            'label' => 'Jumlah',
                        ],
                        [
                            'attribute' => 'deskripsi',
                            'value' => 'deskripsi',
                            'label' => 'Deskripsi',
                        ],
                        [
                            'class' => ActionColumn::className(),
                            'template' => '{update}',
                            'urlCreator' => function ($action, PermintaanDetail $detail, $key, $index, $column) {
                                return Url::toRoute(['$action', 'permintaan_detail_id' => $detail->permintaan_detail_id]);
                            }
                        ],
                    ]
                ]) ?>

            </div>
            <hr>
            <div class="table-responsive">
                <h5>Data BOM</h5>
                <?= GridView::widget([
                    'dataProvider' => new \yii\data\ArrayDataProvider([
                        'allModels' => $bomCustom,
                        'pagination' => false, // Sesuaikan jika tidak menggunakan pagination
                    ]),
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn', 'header' => 'No'],

                        [
                            'attribute' => 'bahan_id',
                            'value' => 'bahan.nama_barang',
                            'label' => 'Nama bahan',
                        ],
                        [
                            'attribute' => 'qty_per_unit',
                            'value' => 'qty_per_unit',
                            'label' => 'Qty Bahan',
                        ],
                        [
                            'attribute' => 'unit',
                            'value' => 'unit.satuan',
                            'label' => 'Satuan',
                        ],
                        [
                            'attribute' => 'catatan',
                            'value' => 'catatan',
                            'label' => 'Catatan',
                        ],
                    ]
                ]) ?>
            </div>
            <?= Html::a('Update', ['update', 'permintaan_id' => $model->permintaan_id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('back', ['index'], ['class' => 'btn btn-secondary']) ?>
            <?= Html::a('Update Bom', [
                'bom-custom/update-multiple',
                'permintaan_detail_id' => $bomCustom[0]['permintaan_detail_id']
            ], ['class' => 'btn btn-secondary']) ?>
        </div>

    </div>

</div>