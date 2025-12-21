<?php

use app\models\Kehadiran;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\KehadiranSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Kehadiran';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pc-content">
    <div class="card table-card">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
            <?= Html::a('Create Kehadiran', ['create'], ['class' => 'btn btn-success']) ?>

        </div>
        <div class="card-body mx-4">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    // 'kehadiran_id',
                    [
                        'attribute' => 'tanggal',
                        'label' => 'Tanggal Hadir',
                        'format' => ['date', 'php:d-M-Y'], // Hasil: 20-12-2025
                    ],
                    [
                        'attribute' => 'tk_id',
                        'value' => 'tenagaKerja.nama',
                        'label' => 'Karyawan',
                    ],
                    [
                        'attribute' => 'shift_id',
                        'value' => 'shift.nama_shift',
                        'label' => 'Shift',
                    ],
                    [
                        'attribute' => 'status_kehadiran',
                        'value' => function ($model) {
                            $list = [
                                0 => 'Hadir',
                                1 => 'Izin',
                                2 => 'Sakit',
                                3 => 'Alpha'
                            ];
                            // Mengembalikan teks berdasarkan angka, jika tidak ada tampilkan '-'
                            return isset($list[$model->status_kehadiran]) ? $list[$model->status_kehadiran] : '-';
                        },
                        'label' => 'Status Kehadiran',
                    ],
                    [
                        'attribute' => 'jam_masuk_real',
                        'label' => 'Jam Masuk',
                        'value' => function ($model) {
                            if (empty($model->jam_masuk_real) || $model->jam_masuk_real == '00:00:00') {
                                return '-';
                            }
                            return Yii::$app->formatter->asTime($model->jam_masuk_real, 'php:H:i');
                        },
                    ],
                    [
                        'attribute' => 'jam_pulang_real',
                        'label' => 'Jam Pulang',
                        'value' => function ($model) {
                            if (empty($model->jam_pulang_real) || $model->jam_pulang_real == '00:00:00') {
                                return '-';
                            }
                            return Yii::$app->formatter->asTime($model->jam_pulang_real, 'php:H:i');
                        },
                    ],
                    [
                        'class' => ActionColumn::className(),
                        'urlCreator' => function ($action, Kehadiran $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'kehadiran_id' => $model->kehadiran_id]);
                        }
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>