<?php

use app\models\WoHeader;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\WoHeaderSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Wo Headers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pc-content">
    <div class="card card-table">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
            <?= Html::a('Create Wo Header', ['create'], ['class' => 'btn btn-success']) ?>

        </div>
        <div class="card-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    // 'wo_id',
                    'kode_wo',
                    'produk_id',
                    'tanggal_dibuat',
                    'tanggal_selesai',
                    'status_wo',
                    'prioritas_wo',
                    [
                        'class' => ActionColumn::className(),
                        'urlCreator' => function ($action, WoHeader $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'wo_id' => $model->wo_id]);
                        }
                    ],
                ],
            ]); ?>
        </div>
    </div>


    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>




</div>