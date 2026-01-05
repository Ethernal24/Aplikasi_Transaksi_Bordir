<?php

use app\models\WorkorderMaterial;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\WorkorderMaterialSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Workorder Materials';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="workorder-material-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Workorder Material', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'wo_mat_id',
            'wo_id',
            'bahan_id',
            'qty_plan',
            'qty_aktual',
            //'status_pengambilan_bahan',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, WorkorderMaterial $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'wo_mat_id' => $model->wo_mat_id]);
                 }
            ],
        ],
    ]); ?>


</div>
