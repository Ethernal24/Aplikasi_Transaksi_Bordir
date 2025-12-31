<?php

use app\models\MpsDetail;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Mps $model */

$this->title = "Detail MPS : " . $model->mps_id;
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
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <?= GridView::widget([
                    'dataProvider' => new \yii\data\ArrayDataProvider([
                        'allModels' => $detail,
                        'pagination' => false, // tidak perlu pagination
                    ]),
                    'columns' => [
                        [
                            'attribute' => 'mps_id',
                            'value' => 'mps.kode_mps',
                            'label' => 'MPS ID',
                        ],
                        [
                            'attribute' => 'permintaan_id',
                            'value' => 'permintaan.kode_permintaan',
                            'label' => 'Permintaan ID',
                        ],
                        [
                            'attribute' => 'produk_id',
                            'value' => 'produk.nama_barang',
                            'label' => 'Produk ID',
                        ],
                        [
                            'attribute' => 'qty_plan',
                            'value' => 'qty_plan',
                            'label' => 'Qty Plan',
                        ],
                    ],
                ]);
                ?>
            </div>
            <?php if ($model->status_mps === 0): ?>
                <?= Html::a('Update', ['update', 'mps_id' => $model->mps_id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Verify', [''], ['class' => 'btn btn-warning']) ?>
            <?php endif; ?>
            <?= Html::a('Back', ['index'], ['class' => 'btn btn-secondary']) ?>
        </div>
    </div>


</div>