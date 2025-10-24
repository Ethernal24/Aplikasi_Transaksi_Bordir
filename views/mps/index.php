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
                        'value' => function ($model) {
                            return $model->barangName;
                        },
                        'label' => 'Nama barang',
                    ],
                    'periode' => [
                        'attribute' => 'periode',
                        'label' => 'Periode',
                        'value' => function ($model) {
                            return date('M-Y', strtotime($model->periode));
                        },
                    ],
                    'tanggal_awal' => [
                        'attribute' => 'tanggal_awal',
                        'label' => 'Tanggal Awal',
                        'value' => function ($model) {
                            return $model->tanggal_awal ? date('d-M-Y', strtotime($model->tanggal_awal)) : "-";
                        },
                    ],
                    'qty',
                    'tipe' => [
                        'attribute' => 'tipe',
                        'value' => function ($model) {
                            $list = [
                                0 => 'MTS',
                                1 => 'MTO',
                            ];
                            return $list[$model->tipe] ?? null;
                        },
                        "label" => 'Tipe',
                    ],
                    'dateline' => [
                        'attribute' => 'dateline',
                        'label' => 'dateline',
                        'value' => function ($model) {
                            return date('d-M-Y', strtotime($model->dateline));
                        },
                    ],
                    'sumber' => [
                        'attribute' => 'sumber',
                        'value' => function ($model) {
                            return $model->sumber ? $model->permintaan->kode_permintaan : "Forecast";
                        },
                        "label" => 'Sumber'

                    ],
                    'status_mps' => [
                        'attribute' => 'status_mps',
                        'value' => function ($model) {
                            $list = [
                                0 => 'Draft',
                                1 => 'Approved',
                            ];
                            return $list[$model->status_mps] ?? null;
                        },
                        "label" => 'Status MPS'

                    ],

                    [
                        'class' => ActionColumn::className(),
                        'template' => '{view} {update}',
                        'urlCreator' => function ($action, Mps $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'mps_id' => $model->mps_id]);
                        }
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>