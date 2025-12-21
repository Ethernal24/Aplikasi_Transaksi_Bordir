<?php

use app\models\ProductionLogDetail;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ProductionLogDetailSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Production Log Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="production-log-detail-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Production Log Detail', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'detail_id',
            'log_id',
            'wo_id',
            'vs',
            'stitch',
            //'kuantitas',
            //'bs',
            //'berat',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, ProductionLogDetail $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'detail_id' => $model->detail_id]);
                 }
            ],
        ],
    ]); ?>


</div>
