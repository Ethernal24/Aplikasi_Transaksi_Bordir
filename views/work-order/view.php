<?php

use yii\bootstrap5\Tabs;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\WorkOrder $model */

$this->title = 'Detail WorkOrder : ' . $model->kode_wo;
$this->params['breadcrumbs'][] = ['label' => 'Work Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pc-content">
    <div class="card table-card">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="card-body mx-4">
            <?= Tabs::widget([
                'items' => [
                    [
                        'label' => '<i class="fa fa-info-circle"></i> General Info',
                        'encode' => false,
                        'content' => $this->render('_tab_general', ['model' => $model]),
                        'active' => true,
                    ],
                    [
                        'label' => '<i class="fa fa-box"></i> Materials (MRP)',
                        'content' => $this->render('_tab_material', ['model' => $model]),
                        'encode' => false,
                    ],
                    [
                        'label' => '<i class="fa fa-tasks"></i> Production Progress',
                        'content' => $this->render('_tab_progress', ['model' => $model]),
                        'encode' => false,
                    ],
                ]
            ]) ?>
        </div>
        <div class="card-footer">
            <?php if ($model->status_wo === 0): ?>

                <?= Html::a('Start Produksi', ['start-production', 'id_wo' => $model->id_wo], [
                    'class' => 'btn btn-success',
                    'data' => [
                        'confirm' => 'Apakah ingin memulai produksi?',
                        'method' => 'post'
                    ]
                ]) ?>
                <!-- <?= Html::a('Delete', ['delete', 'id_wo' => $model->id_wo], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]) ?> -->
            <?php endif; ?>
            <!-- <?= Html::a('Update', ['update', 'id_wo' => $model->id_wo], ['class' => 'btn btn-primary']) ?> -->
            <?= Html::a('Back', 'index', ['class' => 'btn btn-secondary']) ?>
        </div>
    </div>
</div>