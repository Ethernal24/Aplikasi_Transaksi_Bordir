<?php

use app\models\Forecast;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ForecastSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Forecasts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="forecast-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Forecast', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'forecast_id',
            'barang_id',
            'metode',
            'mse',
            'hasil_forecast',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Forecast $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'forecast_id' => $model->forecast_id]);
                 }
            ],
        ],
    ]); ?>


</div>
