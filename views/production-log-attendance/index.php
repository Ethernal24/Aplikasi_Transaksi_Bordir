<?php

use app\models\ProductionLogAttendance;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ProductionLogAttendanceSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Production Log Attendances';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="production-log-attendance-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Production Log Attendance', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'attendance_id',
            'tk_id',
            'log_id',
            'mulai_kerja',
            'selesai_kerja',
            //'waktu_kerja',
            //'mulai_istirahat',
            //'selesai_istirahat',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, ProductionLogAttendance $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'attendance_id' => $model->attendance_id]);
                 }
            ],
        ],
    ]); ?>


</div>
