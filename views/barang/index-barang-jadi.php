<?php

use app\models\Barang;
use yii\bootstrap5\Alert;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\LinkPager;

/** @var yii\web\View $this */
/** @var app\models\BarangSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$pagination = $dataProvider->getPagination();

$this->title = 'List Barang Produksi';
$this->params['breadcrumbs'][] = $this->title;

if (Yii::$app->session->hasFlash('success')) {
    echo Alert::widget([
        'options' => [
            'class' => 'alert-success', // Menggunakan styling success untuk pesan
        ],
        'body' => Yii::$app->session->getFlash('success'), // Menampilkan pesan flash
    ]);
}
?>
<div class="pc-content">
    <div class="card table-card">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
            <?= Html::a('Tambahkan Barang Produksi', ['create-barang-jadi'], ['class' => 'btn btn-success']) ?>
            <?= Html::a('Tambahkan BOM', ['bom/create'], ['class' => 'btn btn-success']) ?>
            <?= Html::a('List Bahan Baku', ['index'], ['class' => 'btn btn-info']) ?>
        </div>
        <div class="card-body mx-4">
            <div class="table-responsive">


                <?php // echo $this->render('_search', ['model' => $searchModel]); 
                ?>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        // 'barang_id',
                        // 'kode_barang',
                        [
                            'attribute' => 'kode_barang',
                            'filterInputOptions' => [
                                'class' => 'form-control',
                                'placeholder' => 'Cari Kode Barang',
                            ],
                        ],
                        // 'nama_barang',
                        [
                            'attribute' => 'nama_barang',
                            'filterInputOptions' => [
                                'class' => 'form-control',
                                'placeholder' => 'Cari Nama Barang',
                            ],
                        ],
                        [
                            'attribute' => 'jenis',
                            'label' => 'Jenis',
                            'value' => function ($model) {
                                $list = [
                                    0 => 'Beli',
                                    1 => 'Produksi',
                                ];
                                return $list[$model->jenis] ?? null;
                            },
                            'filter' => [
                                '0' => 'Beli',
                                '1' => 'Produksi',
                            ],
                            'filterInputOptions' => [
                                'class' => 'form-control',
                                'prompt' => 'Pilih Jenis'
                            ]
                        ],
                        [
                            'attribute' => 'stok',
                            'value' => function ($model) {
                                return $model->stocks ? $model->stocks->quantity_akhir : '-';
                            },
                        ],

                        'unit.satuan' => [
                            'attribute' => 'satuan',
                            'value' => 'unit.satuan',
                            'label' => 'Satuan',
                            'filterInputOptions' => [
                                'class' => 'form-control',
                                'placeholder' => 'Cari satuan',
                            ],
                        ],
                        'leadtime',
                        [
                            'attribute' => 'tipe_barang',
                            'value' => function ($model) {
                                $list = [
                                    0 => 'Bahan Baku',
                                    1 => 'Setengah Jadi',
                                    2 => 'Barang Jadi',
                                    3 => 'Non Consumable',
                                    4 => 'Template',
                                ];
                                return $list[$model->tipe_barang] ?? null;
                            },
                            'filter' => [
                                '2' => 'Barang Jadi',
                                '4' => 'Template',
                            ],
                            'filterInputOptions' => [
                                'class' => 'form-control',
                                'prompt' => 'Pilih Tipe',
                            ],
                        ],
                        [
                            'class' => ActionColumn::className(),
                            'template' => '{update} {view}',
                            'urlCreator' => function ($action, Barang $model, $key, $index, $column) {
                                if ($action === 'update') {
                                    $backUrl = $model->tipe_barang == 2 ? 'index-barang-jadi' : 'index';
                                    return Url::toRoute([$action, 'barang_id' => $model->barang_id, 'backurl' => $backUrl]);
                                }
                                return Url::toRoute([$action, 'barang_id' => $model->barang_id]);
                            }
                        ],
                    ],
                ]); ?>


            </div>
        </div>
    </div>
</div>