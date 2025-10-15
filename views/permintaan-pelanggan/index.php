<?php

use app\models\PermintaanPelanggan;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\PermintaanPelangganSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Data Pelanggan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pc-content">
    <div class="card table-card">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
            <?= Html::a('Create Data Pelanggan', ['create'], ['class' => 'btn btn-success']) ?>
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

                        // 'permintaan_id',
                        'kode_permintaan',
                        'nama_pelanggan',
                        'tanggal_permintaan',
                        'tenggat_waktu',
                        [
                            'attribute' => 'status_pesanan',
                            'value' => function ($model) {
                                $list = [
                                    0 => 'antrian',
                                    1 => 'prosess',
                                    2 => 'selesai',
                                ];
                                return $list[$model->status_pesanan] ?? null;
                            }

                        ],
                        [
                            'class' => ActionColumn::className(),
                            'urlCreator' => function ($action, PermintaanPelanggan $model, $key, $index, $column) {
                                return Url::toRoute([$action, 'permintaan_id' => $model->permintaan_id]);
                            }
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>





</div>