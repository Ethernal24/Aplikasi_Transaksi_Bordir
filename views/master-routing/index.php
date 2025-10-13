<?php

use app\models\MasterRouting;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\MasterRoutingSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Master Routings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pc-content">
    <div class="card card-table">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
            <?= Html::a('Create Master Routing', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="card-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'routing_id',
                    'nama_routing',
                    'deskripsi',
                    [
                        'class' => ActionColumn::className(),
                        'urlCreator' => function ($action, MasterRouting $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'routing_id' => $model->routing_id]);
                        }
                    ],
                ],
            ]); ?>
        </div>
    </div>

    


</div>
