<?php

use app\models\MrpDetail;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\MrpDetailSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Mrp Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mrp-detail-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Mrp Detail', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'mrp_detail_id',
            'mrp_id',
            'bahan_id',
            'kebutuhan_kotor',
            'stock_tersedia',
            'kebutuhan_bersih',
            'leadtime',
            'planned_order_release',
            'planned_order_receipt',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, MrpDetail $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'mrp_detail_id' => $model->mrp_detail_id]);
                }
            ],
        ],
    ]); ?>


</div>