<?php

use app\models\RiwayatPermintaan;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\RiwayatPermintaanSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Riwayat Permintaan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pc-content">
    <div class="card table-card">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
            <?= Html::a('Create Riwayat Permintaan', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="card-body mx-4">
            <div class="table-responsive">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        // 'riwayat_id',
                        'barang_id' => [
                            'attribute' => 'barang_id',
                            'value' => 'barang.nama_barang',
                            'label' => 'Nama Produk',

                        ],
                        'bulan' => [
                            'attribute' => 'bulan',
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
                                return $list[$model->bulan] ?? null;
                            }
                        ],
                        'tahun',
                        'jumlah_permintaan',
                        [
                            'class' => ActionColumn::className(),
                            'urlCreator' => function ($action, RiwayatPermintaan $model, $key, $index, $column) {
                                return Url::toRoute([$action, 'riwayat_id' => $model->riwayat_id]);
                            }
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>


    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>




</div>