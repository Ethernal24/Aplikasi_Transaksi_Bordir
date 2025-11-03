<?php

use app\models\MpsDetail;
use kartik\grid\GridView;
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
                <div><strong>
                        Nama Produk :
                    </strong> <?= $model->barangName ?>
                </div>
                <div><strong>
                        Periode :
                    </strong> <?= Yii::$app->formatter->asDatetime($model->periode, 'php: F Y') ?>
                </div>
            </div>
            <div class="col">
                <div><strong>
                        Tipe :
                    </strong> <?= $model->tipeLabel ?>
                </div>
                <div><strong>
                        Status Approved :
                    </strong>
                    <span class="<?= $model->getStatusLabel()['class'] ?>"><?= $model->getStatusLabel()['label'] ?></span>
                </div>
            </div>
            <div class="col">
                <div><strong>
                        Stok On Hand :
                    </strong> <?= $model->barang->stok ?>
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
                            'attribute' => 'minggu_ke',
                            'value' => 'minggu_ke',
                            'label' => 'Minggu Ke',
                        ],
                        [
                            'attribute' => 'forecast',
                            'value' => 'forecast',
                            'label' => 'Forecast',
                        ],
                        [
                            'attribute' => 'order_aktual',
                            'value' => 'order_aktual',
                            'label' => 'Order Aktual',
                        ],
                        [
                            'attribute' => 'stok',
                            'value' => 'stok',
                            'label' => 'Stok',
                        ],
                        [
                            'attribute' => 'rencana_produksi',
                            'value' => 'rencana_produksi',
                            'label' => 'Rencana Produksi',
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