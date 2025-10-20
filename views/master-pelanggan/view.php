<?php

use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\MasterPelanggan $model */

$this->title = "Data Pelanggan : " . $model->nama_pelanggan;
$this->params['breadcrumbs'][] = ['label' => 'Master Pelanggans', 'url' => ['index']];
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
                <div><strong>Nama Pelanggan : </strong><?= $model->nama_pelanggan ?></div>
            </div>
            <div class="col">
                <div><strong>Nama Instansi : </strong><?= $model->instansi ?></div>
            </div>
            <div class="col">
                <div><strong>Terkahir Pesan : </strong><?= $model->pesenan_terakhir ?></div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <h5>Data Produk</h5>
                <?= GridView::widget([
                    'dataProvider' => new \yii\data\ArrayDataProvider([
                        'allModels' => $produk,
                        'pagination' => false, // Sesuaikan jika tidak menggunakan pagination
                    ]),
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn', 'header' => 'No'],
                        [
                            'attribute' => 'barang_id',
                            'label' => 'Nama Barang',
                            'value' => function ($model) {
                                return $model->barang->nama_barang ?? '-';
                            }
                        ],

                        [
                            'attribute' => 'jumlah',
                            'value' => 'jumlah',
                            'label' => 'jumlah',
                        ],
                        [
                            'attribute' => 'deskripsi',
                            'value' => 'deskripsi',
                            'label' => 'Deskripsi',
                        ],
                        // [
                        //     'class' => ActionColumn::className(),
                        //     'template' => '{update}',
                        //     'urlCreator' => function ($action, PermintaanDetail $detail, $key, $index, $column) {
                        //         return Url::toRoute(['$action', 'permintaan_detail_id' => $detail->permintaan_detail_id]);
                        //     }
                        // ],
                    ]
                ]) ?>
            </div>
            <?= Html::a('Update', ['update', 'pelanggan_id' => $model->pelanggan_id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'pelanggan_id' => $model->pelanggan_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>
</div>