<?php

use app\models\Mps;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\MpsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Master Production Schedule';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pc-content">
    <div class="card table-card">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
            <?= Html::a('Buat Mps', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="card-body mx-4">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    // 'mps_id',
                    'barang_id' => [
                        'attribute' => 'barang_id',
                        'value' => 'barang.nama_barang',
                        'label' => 'Nama barang',
                    ],
                    'periode'=>[
                        'attribute' => 'periode',
                        'label' => 'Periode',
                        'value' => function ($model) {
                            $list = [
                                '1' => 'Januari',
                                '2' => 'Februari',
                                '3' => 'Maret',
                                '4' => 'April',
                                '5' => 'Mei',
                                '6' => 'Juni',
                                '7' => 'Juli',
                                '8' => 'Agustus',
                                '9' => 'September',
                                '10' => 'Oktober',
                                '11' => 'November',
                                '12' => 'Desember',
                            ];
                            return $list[$model->periode] ?? null;
                        },
                    ],
                    'qty',
                    'tipe' =>[
                        'attribute' => 'tipe',
                        'value' => function ($model) {
                                $list = [
                                    0 => 'MTS',
                                    1 => 'MTO',
                                ];
                                return $list[$model->status_mps] ?? null;
                            },
                        "label" => 'Tipe',
                        ],
                    'dateline',
                    // 'sumber' =>[
                    //     'attribute' => 'sumber',
                    //     'value' => function ($model) {
                    //             $list = [
                    //                 0 => 'Forecast',
                    //                 1 => 'MTO',
                    //             ];
                    //             return $list[$model->sumber] ?? null;
                    //         },
                    //     "label" => 'sumber',
                    //     ],
                    'status_mps'=>[
                        'attribute' => 'status_mps',
                        'value' => function ($model) {
                                $list = [
                                    0 => 'pending',
                                    1 => 'approved',
                                ];
                                return $list[$model->status_mps] ?? null;
                            },
                        "label" => 'Status MPS'

                    ],
                    [
                        'class' => ActionColumn::className(),
                        'urlCreator' => function ($action, Mps $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'mps_id' => $model->mps_id]);
                        }
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>