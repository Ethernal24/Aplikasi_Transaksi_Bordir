<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\ProductionLog $model */

$this->title = 'Laporan Shift No. ' . $model->production_log_id;
$this->params['breadcrumbs'][] = ['label' => 'Production Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pc-content">
    <div class="card table-card">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="row mx-3">
            <div class="col-md-3">
                <div><strong>Tanggal Kerja : </strong> <?= $model->tanggal ?></div>
                <div><strong>Nama Mesin : </strong> <?= $model->mesin->nama_mesin ?></div>
            </div>
            <div class="col-md-3">
                <div><strong>Tenaga Kerja : </strong> <?= $model->tenagaKerja->nama ?></div>
                <div><strong>Shift : </strong> <?= $model->shift->nama_shift ?></div>
            </div>
            <div class="col-md-3">
                <div><strong>Mulai Kerja : </strong> <?= $model->mulai_kerja ?></div>
                <div><strong>Selesai Kerja : </strong> <?= $model->selesai_kerja ?></div>
            </div>
            <div class="col-md-3">
                <div><strong>Mulai Istirahat : </strong> <?= $model->mulai_istirahat ?></div>
                <div><strong>Selesai Istirahat : </strong> <?= $model->selesai_istirahat ?></div>
            </div>
        </div>
        <hr>
        <div class="card-body mx-4">
            <h5>Detail</h5>
            <div class="table-responsive">
                <?= GridView::widget([
                    'dataProvider' => new \yii\data\ArrayDataProvider([
                        'allModels' => $detail,
                        'pagination' => false, // Sesuaikan jika tidak menggunakan pagination
                    ]),
                    // Harus menunjukkan 5 jika terdapat 5 data
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn', 'header' => 'No'],
                        // 'produk_id',
                        [
                            'attribute' => 'log_id',
                        ],
                        [
                            'attribute' => 'wo_id',
                        ],
                        [
                            'attribute' => 'vs',
                        ],
                        [
                            'attribute' => 'stitch',
                        ],
                        [
                            'attribute' => 'kuantitas',
                        ],
                        [
                            'attribute' => 'bs',
                        ],
                        [
                            'attribute' => 'berat',
                        ],

                    ],

                ]);
                ?>
            </div>
        </div>
        <hr>
        <div class="card-body mx-4">
            <h5>Activity</h5>
            <div class="table-responsive">
                <?= GridView::widget([
                    'dataProvider' => new \yii\data\ArrayDataProvider([
                        'allModels' => $activity,
                        'pagination' => false, // Sesuaikan jika tidak menggunakan pagination
                    ]),
                    // Harus menunjukkan 5 jika terdapat 5 data
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn', 'header' => 'No'],
                        // 'produk_id',
                        [
                            'attribute' => 'log_id',
                        ],
                        [
                            'attribute' => 'ganti_benang',
                        ],
                        [
                            'attribute' => 'ganti_kain',
                        ],
                        [
                            'attribute' => 'kendala',
                        ],
                        [
                            'attribute' => 'durasi_menit',
                        ],

                    ],

                ]);
                ?>
            </div>
        </div>
        <div class="card-footer">
            <?= Html::a('Update', ['update', 'production_log_id' => $model->production_log_id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Back', ['index'], ['class' => 'btn btn-secondary']) ?>
        </div>
    </div>
</div>