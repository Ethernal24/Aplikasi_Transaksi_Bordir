<?php

use app\models\RoutingDetail;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\RoutingDetailSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Routing Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="routing-detail-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Routing Detail', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'routing_detail_id',
            'routing_id',
            'urutan',
            'nama_proses',
            'mesin_id',
            //'tenaga_kerja_id',
            //'waktu_setup_menit',
            //'waktu_operasi_menit_per_unit',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, RoutingDetail $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'routing_detail_id' => $model->routing_detail_id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
