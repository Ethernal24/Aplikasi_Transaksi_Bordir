<?php

use app\models\ProductionLogActivity;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ProductionLogActivitySearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Production Log Activities';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="production-log-activity-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Production Log Activity', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'activity_id',
            'log_id',
            'ganti_benang',
            'ganti_kain',
            'kendala',
            //'durasi_menit',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, ProductionLogActivity $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'activity_id' => $model->activity_id]);
                 }
            ],
        ],
    ]); ?>


</div>
