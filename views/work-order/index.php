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
            <!-- <?= Html::a('Create Work Order', ['create'], ['class' => 'btn btn-success']) ?> -->
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
                        'buttons' => [
                            'view' => function ($url, $model, $key) {
                                // Kita buat URL manual khusus untuk tombol View dengan 2 variabel
                                $customUrl = Url::to([
                                    'view',
                                    'id_wo' => $model->id_wo,
                                    'token' => $model->permintaan->tracking_token // Variabel kedua Anda di sini
                                ]);
                                return Html::a('<span class="fas fa-eye"></span>', $customUrl, [
                                    'title' => 'View',
                                    'data-pjax' => '0',
                                ]);
                            },
                        ],
                        'urlCreator' => function ($action, $model, $key, $index, $column) {
                            // urlCreator ini akan tetap melayani tombol Delete (karena hanya 1 variabel)
                            return Url::toRoute([$action, 'id_wo' => $model->id_wo]);
                        }
                    ]
                ],
            ]); ?>
        </div>
    </div>


    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>




</div>