<?php

use app\models\ProductionLogDowntime;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ProductionLogDowntimeSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Production Log Downtimes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="production-log-downtime-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Production Log Downtime', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'downtime_id:datetime',
            'log_id',
            'ganti_benang',
            'ganti_kain',
            'kendala',
            //'durasi_menit',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, ProductionLogDowntime $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'downtime_id' => $model->downtime_id]);
                 }
            ],
        ],
    ]); ?>


</div>
