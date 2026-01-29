<?php

use app\models\MasterMrp;
use app\models\MpsDetail;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Mps $model */

$this->title = "Detail MPS : " . $model->kode_mps;
$this->params['breadcrumbs'][] = ['label' => 'Mps', 'url' => ['index']];
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
                    <strong>
                        Periode :
                    </strong> <?= Yii::$app->formatter->asDatetime($model->periode, 'php: F Y') ?>
                </div>
                <div>
                    <strong>
                        Tanggal Awal :
                    </strong> <?= Yii::$app->formatter->asDatetime($model->tanggal_awal, 'php: d F Y ') ?>
                </div>
            </div>
            <div class="col">
                <div>
                    <strong>
                        Status Approved :
                    </strong>
                    <span class="<?= $model->getStatusLabel()['class'] ?>"><?= $model->getStatusLabel()['label'] ?></span>
                </div>
                <div>
                    <strong>
                        Tanggal Akhir :
                    </strong>
                    <?= Yii::$app->formatter->asDatetime($model->tanggal_akhir, 'php: d F Y ') ?>
                </div>
            </div>
            <div class="col">
                <!-- <div>
                    <strong>
                        Prioritas :
                    </strong>
                    <span class="<?= $model->getPrioritasLabel()['class'] ?>"><?= $model->getPrioritasLabel()['label'] ?></span>
                </div> -->
                <div>
                    <strong>
                        Buffer Time :
                    </strong>
                    <?= $model->buffer_time ?>%
                </div>
            </div>
        </div>
        <hr>
        <div class="card-body">
            <h4>Detail Permintaan</h4>
            <div class="table-responsive">
                <?= GridView::widget([
                    'dataProvider' => new \yii\data\ArrayDataProvider([
                        'allModels' => $detail,
                        'pagination' => false, // tidak perlu pagination
                    ]),
                    'columns' => [
                        [
                            'attribute' => 'permintaan_id',
                            'value' => 'permintaan.kode_permintaan',
                            'label' => 'Kode Permintaan',
                        ],
                        [
                            'attribute' => 'produk_id',
                            'value' => 'produk.nama_barang',
                            'label' => 'Nama Produk',
                        ],
                        [
                            'attribute' => 'qty_plan',
                            'value' => 'qty_plan',
                            'label' => 'Qty Plan',
                        ],
                        [
                            'attribute' => 'routing_id',
                            'value' => 'routing.nama_routing',
                            'label' => 'Routing',
                        ],
                        [
                            'attribute' => 'estimasi_selesai',
                            'value' => 'estimasi_selesai',
                            'label' => 'Estimasi Selesai',
                        ]
                    ],
                ]);
                ?>
            </div>
            <hr>


            <?php if ($model->status_mps === 0): ?>
                <?= Html::a('Update', ['update', 'mps_id' => $model->mps_id], ['class' => 'btn btn-primary']) ?>

                <?php
                $mrpModel = MasterMrp::find()->where(['mps_id' => $model->mps_id])->one();

                // 2. Tentukan status (apakah sudah ada dan apakah sudah disetujui)
                $mrpExist = ($mrpModel !== null);
                $isApproved = ($mrpExist && $mrpModel->status == 1); // Sesuaikan '1' dengan nilai status Approved Anda

                // 3. Tampilkan tombol HANYA JIKA belum disetujui
                if (!$isApproved): ?>
                    <?= Html::a(
                        $mrpExist ? 'Generate Ulang MRP' : 'Generate MRP',
                        ['generate-mrp', 'mps_id' => $model->mps_id],
                        [
                            'class' => $mrpExist ? 'btn btn-warning' : 'btn btn-info',
                            'data' => [
                                'confirm' => $mrpExist ? 'MRP sudah pernah dibuat, apa ingin generate ulang? (Data lama akan dihapus)' : 'Apakah ingin menjalankan simulasi MRP?',
                                'method' => 'post',
                            ],
                        ]
                    ) ?>
                    <?= Html::a(
                        'Verify',
                        ['verify', 'mps_id' => $model->mps_id],
                        [
                            'class' => 'btn btn-secondary disabled',
                            'style' => 'cursor: not-allowed;',
                            'title' => 'MRP blom di generate atau disetujui.',
                        ]
                    ) ?>
                <?php else: ?>
                    <?= Html::a(
                        'Verify',
                        ['verify', 'mps_id' => $model->mps_id],
                        [
                            'class' => 'btn btn-warning',
                            'data' => [
                                'confirm' => 'Apakah anda yakin semua data sudah benar? status akan berubah',
                                'method' => 'post',
                            ],
                        ]
                    ) ?>
                    <?= Html::button('<i class="fa fa-lock"></i> MRP Terkunci (Approved)', [
                        'class' => 'btn btn-secondary disabled',
                        'style' => 'cursor: not-allowed;',
                        'title' => 'MRP sudah disetujui dan tidak dapat diubah lagi.',
                    ]) ?>
                <?php endif; ?>
            <?php endif; ?>
            <?= Html::a('Back', ['index'], ['class' => 'btn btn-secondary']) ?>
        </div>
    </div>


</div>