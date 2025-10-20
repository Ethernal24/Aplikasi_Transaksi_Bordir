<?php

use app\models\MasterMrp;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\MasterMrpSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Master Mrps';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-mrp-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Master Mrp', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'mrp_id',
            'mps_id',
            'status',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, MasterMrp $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'mrp_id' => $model->mrp_id]);
                 }
            ],
        ],
    ]); ?>


</div>
