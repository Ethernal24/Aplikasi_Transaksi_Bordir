<?php

use app\models\MasterPelanggan;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\MasterPelangganSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Daftar Pelanggan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pc-content">
    <div class="card table-card">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
            <?= Html::a('Buat Daftar Pelanggan', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="card-body mx-4">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    // 'pelanggan_id',
                    'kode',
                    'nama_pelanggan',
                    'instansi',
                    'no_telp',
                    [
                        'attribute' => 'pesenan_terakhir',
                        'value' => function ($model) {
                            return $model->pesenan_terakhir ? Yii::$app->formatter->asDate($model->pesenan_terakhir, 'php:d-mm-Y') : '-';
                        },
                        'label' => 'Pesanan Terakhir',
                    ],
                    [
                        'class' => ActionColumn::className(),
                        'urlCreator' => function ($action, MasterPelanggan $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'pelanggan_id' => $model->pelanggan_id]);
                        }
                    ],
                ],
            ]); ?>
        </div>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>
</div>