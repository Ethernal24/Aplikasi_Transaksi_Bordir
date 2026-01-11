<?php

use app\models\Workcenter;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\WorkcenterSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Workcenters';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pc-content">
    <div class="card card-table">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
            <?= Html::a('Create Workcenter', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="card-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    // 'workcenter_id',
                    'kode_workcenter',
                    'nama_workcenter',
                    [
                        'attribute' => 'tipe_kapasitas',
                        'label' => 'Tipe Kapasitas',
                        'value' => function ($model) {
                            $list = [
                                0 => 'Mesin',
                                1 => 'Orang',
                                2 => 'Mesin & Orang',
                            ];
                            return $list[$model->tipe_kapasitas] ?? null;
                        }
                    ],
                    'keterangann',
                    [
                        'class' => ActionColumn::className(),
                        'template' => '{update} {delete}',
                        'urlCreator' => function ($action, Workcenter $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'workcenter_id' => $model->workcenter_id]);
                        }
                    ],
                ],
            ]); ?>
        </div>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>




</div>