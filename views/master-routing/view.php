<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\MasterRouting $model */

$this->title = 'Routing ' . $model->nama_routing;
$this->params['breadcrumbs'][] = ['label' => 'Master Routings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pc-content">
    <div class="card card-table">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <?= GridView::widget([
                    'dataProvider' => new \yii\data\ArrayDataProvider([
                        'allModels' => $detail,
                        'pagination' => false,
                    ]),
                    'columns' => [
                        [
                            'attribute' => 'urutan',
                            'value' => 'urutan',
                            'label' => 'urutan',
                        ],
                        [
                            'attribute' => 'nama_proses',
                            'value' => 'nama_proses',
                            'label' => 'Nama Proses',
                        ],
                        [
                            'attribute' => 'mesin_id',
                            'value' => function ($model) {
                                return $model->mesin ? $model->mesin->nama : '-';
                            },
                            'label' => 'Mesin',
                        ],
                        [
                            'attribute' => 'tenaga_kerja_id',
                            'value' => 'tenagaKerja.nama',
                            'label' => 'Tenaga Kerja',
                        ],
                        [
                            'attribute' => 'waktu_setup_menit',
                            'value' => 'waktu_setup_menit',
                            'label' => 'Waktu setup (menit)',
                        ],
                        [
                            'attribute' => 'waktu_pengerjaan_menit',
                            'value' => 'waktu_pengerjaan_menit',
                            'label' => 'Waktu Pengerjaan (menit)',
                        ],
                    ]
                ]) ?>
                <div class="form-group">
                    <?= Html::a('Update', ['update', 'routing_id' => $model->routing_id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Back', ['index'], [
                        'class' => 'btn btn-secondary',

                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>