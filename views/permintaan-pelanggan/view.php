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
                <div><strong>Nama Pelanggan : </strong> <?= $model->pelanggan->nama_pelanggan ?></div>
            </div>
            <div class="col">
                <div><strong>Tanggal Permintaan : </strong> <?= Yii::$app->formatter->asDate($model->tanggal_permintaan, 'php: d-mm-yy') ?></div>
                <div><strong>Tenggat Waktu : </strong> <?= Yii::$app->formatter->asDate($model->tenggat_waktu, 'php: d-mm-yy') ?></div>
            </div>
            <div class="col">
                <div>
                    <strong>Status Pesanan : </strong>
                    <span class="<?= $model->getLabel()['class'] ?>"><?= $model->getLabel()['label'] ?></span>
                </div>
                <div><strong>Asal Instansi : </strong> <?= $model->pelanggan->instansi ?></div>

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
                            'attribute' => 'produk_id',
                            'value' => 'produk.nama_barang',
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
                    ]
                ]) ?>

            </div>
            <hr>

            <?= Html::a('Update', ['update', 'permintaan_id' => $model->permintaan_id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('back', ['index'], ['class' => 'btn btn-secondary']) ?>

        </div>

    </div>

</div>