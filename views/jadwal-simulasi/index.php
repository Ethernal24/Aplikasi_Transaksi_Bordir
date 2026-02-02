<?php

use app\models\JadwalSimulasi;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\JadwalSimulasiSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Jadwal Simulasi';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pc-content">
    <div class="card table-card">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
            <?= Html::a('Buat Jadwal Simulasi', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="card-body mx-4">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    // 'simulasi_id',
                    [
                        'attribute' => 'produk_id',
                        'value' => 'produk.nama_barang',
                        'label' => 'Nama Produk',
                    ],
                    'pelanggan_id',
                    'quantity',
                    'tanggal_mulai',
                    'dateline',
                    'estimasi_selesai',
                    [
                        'class' => ActionColumn::className(),
                        'urlCreator' => function ($action, JadwalSimulasi $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'simulasi_id' => $model->simulasi_id]);
                        }
                    ],
                ],
            ]); ?>
        </div>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>




</div>