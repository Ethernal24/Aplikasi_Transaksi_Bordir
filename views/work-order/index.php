<?php

use app\models\WorkOrder;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\WorkOrderSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Work Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pc-content">

    <div class="card table-card">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
            <?= Html::a('Create Work Order', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="card-body mx-4">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    // 'id_wo',
                    'kode_wo',
                    [
                        'attribute' => 'permintaan_id',
                        'value' => 'permintaan.kode_permintaan',
                        'label' => 'Kode Permintaan',
                    ],
                    // 'id_routing',
                    // 'qty_target',
                    'tanggal_wo',
                    'due_date',
                    [
                        'attribute' => 'status_wo',
                        'label' => 'Status WO',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $label = $model->labelStatus;
                            return "<span class= '{$label['class']}'>{$label['label']}</span>";
                        },
                    ],
                    [
                        'attribute' => 'prioritas',
                        'label' => 'Prioritas',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $label = $model->LabelPrioritas;
                            return "<span class= '{$label['class']}'>{$label['label']}</span>";
                        },
                    ],
                    // 'created_at',
                    // 'updated_at',
                    [
                        'class' => ActionColumn::className(),
                        'template' => '{delete} {view}',
                        'urlCreator' => function ($action, WorkOrder $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'id_wo' => $model->id_wo]);
                        }
                    ],
                ],
            ]); ?>
        </div>
    </div>


    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>




</div>