<?php

use app\models\ProdukCustomPelanggan;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ProdukCustomPelangganSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Produk Custom Pelanggans';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="produk-custom-pelanggan-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Produk Custom Pelanggan', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'produk_custom_pelanggan_id',
            'pelanggan_id',
            'kode_barang',
            'nama_barang_custom',
            'dibuat_pada',
            //'diupdate_pada',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, ProdukCustomPelanggan $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'produk_custom_pelanggan_id' => $model->produk_custom_pelanggan_id]);
                 }
            ],
        ],
    ]); ?>


</div>
