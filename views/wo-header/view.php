<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\WoHeader $model */

$this->title = 'Detail ' . $model->kode_wo;
$this->params['breadcrumbs'][] = ['label' => 'Wo Headers', 'url' => ['index']];
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
                    </strong>
                    <?= $model->produk_id ?>
                </div>
                <div><strong>
                        Prioritas WO :
                    </strong>
                    <?= $model->prioritas_wo ?>
                </div>
            </div>
            <div class="col">
                <div><strong>
                        Tanggal Selesai :
                    </strong>
                    <?= $model->tanggal_selesai ?>
                </div>
                <div><strong>
                        Status WO :
                    </strong>
                    <?= $model->status_wo ?>
                </div>
            </div>
        </div>
        <br>
        <div class="card-body">
            <div class="table-responsive">
                <?= GridView::widget([
                    'dataProvider' => new \yii\data\ArrayDataProvider([
                        'allModels' => $detailOpr,
                        'pagination' => false, // tidak perlu pagination
                    ]),
                    'columns' => [
                        [
                            'attribute' => 'urutan_operasi',
                            'value' => 'urutan_operasi',
                            'label' => 'Urutan Operasi',
                        ],
                        [
                            'attribute' => 'mesin_id',
                            'value' => 'mesin_id',
                            'label' => 'Mesin ID',
                        ],
                        [
                            'attribute' => 'shift_id',
                            'value' => 'shift_id',
                            'label' => 'Shift ID',
                        ],
                        [
                            'attribute' => 'waktu_standar_menit',
                            'value' => 'waktu_standar_menit',
                            'label' => 'Waktu Standar',
                        ],
                    ],
                ]);
                ?>
            </div>
            <br>
            <div class="table-responsive">
                <?= GridView::widget([
                    'dataProvider' => new \yii\data\ArrayDataProvider([
                        'allModels' => $detailMat,
                        'pagination' => false, // tidak perlu pagination
                    ]),
                    'columns' => [
                        [
                            'attribute' => 'urutan_operasi',
                            'value' => 'urutan_operasi',
                            'label' => 'Urutan Operasi',
                        ],
                        [
                            'attribute' => 'mesin_id',
                            'value' => 'mesin_id',
                            'label' => 'Mesin ID',
                        ],
                        [
                            'attribute' => 'shift_id',
                            'value' => 'shift_id',
                            'label' => 'Shift ID',
                        ],
                        [
                            'attribute' => 'waktu_standar_menit',
                            'value' => 'waktu_standar_menit',
                            'label' => 'Waktu Standar',
                        ],
                    ],
                ]);
                ?>
            </div>


            <?= Html::a('Update', ['update', 'wo_id' => $model->wo_id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Back', ['index'], ['class' => 'btn btn-secondary']) ?>
        </div>
    </div>








</div>