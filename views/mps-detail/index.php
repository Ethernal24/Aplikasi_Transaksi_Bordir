<?php

use app\models\MpsDetail;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\MpsDetailSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Mps Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mps-detail-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Mps Detail', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'mps_detail_id',
            'mps_id',
            'minggu_ke',
            'forecast',
            'order_aktual',
            //'stok',
            //'rencana_produksi',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, MpsDetail $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'mps_detail_id' => $model->mps_detail_id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
