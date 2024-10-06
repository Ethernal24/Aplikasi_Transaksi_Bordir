<?php

use app\models\Barangproduksi;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\Barangproduksisearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Barangproduksi';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pc-content">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Barangproduksi', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'barang_id',
            'nama',
            'nama_jenis',
            'deskripsi:ntext',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Barangproduksi $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'barang_id' => $model->barang_id]);
                 }
            ],
        ],
    ]); ?>


</div>
