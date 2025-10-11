<?php

use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Mesin $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="mesin-form">
    <div class="card table-card">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="card-body mx-4">
            <?php $form = ActiveForm::begin(); ?>
            <div id="mesin-gridview">
                <?= GridView::widget([
                    'dataProvider' => new ArrayDataProvider([
                        'allModels' => $modelMesins,
                        'pagination' => false,
                    ]),
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'nama',
                            'format' => 'raw',
                            'value' => function ($model, $key, $index, $column) use ($form) {
                                return $form
                                    ->field($model, "[$index]nama")
                                    ->textInput(['maxlength' => true])
                                    ->label(false);
                            }
                        ],
                        [
                            'attribute' => 'kode_mesin',
                            'format' => 'raw',
                            'value' => function ($model, $key, $index, $column) use ($form) {
                                return $form
                                    ->field($model, "[$index]kode_mesin")
                                    ->textInput(['maxlength' => true])
                                    ->label(false);
                            }
                        ],
                        [
                            'attribute' => 'kapasitas_per_jam',
                            'format' => 'raw',
                            'value' => function ($model, $key, $index, $column) use ($form) {
                                return $form
                                    ->field($model, "[$index]kapasitas_per_jam")
                                    ->textInput(['maxlength' => true])
                                    ->label(false);
                            }
                        ],
                        [
                            'attribute' => 'status_mesin',
                            'format' => 'raw',
                            'value' => function ($model, $key, $index, $column) use ($form) {
                                return $form
                                    ->field($model, "[$index]status_mesin")
                                    ->textInput(['maxlength' => true])
                                    ->label(false);
                            }
                        ],
                        [
                            'attribute' => 'waktu_setup',
                            'format' => 'raw',
                            'value' => function ($model, $key, $index, $column) use ($form) {
                                return $form
                                    ->field($model, "[$index]waktu_setup")
                                    ->textInput(['maxlength' => true])
                                    ->label(false);
                            }
                        ],
                        [
                            'attribute' => 'waktu_operasi',
                            'format' => 'raw',
                            'value' => function ($model, $key, $index, $column) use ($form) {
                                return $form
                                    ->field($model, "[$index]waktu_operasi")
                                    ->textInput(['maxlength' => true])
                                    ->label(false);
                            }
                        ],
                        [
                            'attribute' => 'kategori',
                            'format' => 'raw',
                            'value' => function ($model, $key, $index, $column) use ($form) {
                                return $form
                                    ->field($model, "[$index]kategori")
                                    ->textInput(['maxlength' => true])
                                    ->label(false);
                            }
                        ],
                        [
                            'attribute' => 'deskripsi',
                            'format' => 'raw',
                            'value' => function ($model, $key, $index, $column) use ($form) {
                                return $form
                                    ->field($model, "[$index]deskripsi")
                                    ->textInput(['maxlength' => true])
                                    ->label(false);
                            }
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{actions}',
                            'buttons' => [
                                'actions' => function ($url, $model) {
                                    return Html::tag(
                                        'div',
                                        Html::a(Html::tag('i', '', ['class' => 'fas fa-plus fa-xs']), '#', [
                                            'class' => 'btn btn-success btn-xs pb-1 px-2 add-row ',
                                            'onclick' => 'return false;',
                                        ]) .
                                            Html::a(Html::tag('i', '', ['class' => 'fas fa-trash fa-xs']), '#', [
                                                'class' => 'btn btn-danger btn-xs pb-1 px-2 delete-row ',
                                                'onclick' => 'return false;',
                                            ]),
                                        ['class' => 'd-flex justify-content-between align-content-center align-items-center']
                                    );
                                },
                            ],
                        ],

                    ],
                ]); ?>
            </div>
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Back', ['mesin/index'], ['class' => 'btn btn-secondary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>

<style>
    .small-btn {
        padding: 2px 6px;
        font-size: 0.8em;
        margin-right: 2px;
    }

    /* Mengatur tata letak tombol secara horizontal */
    .action-buttons {
        display: flex;
        align-items: center;
        gap: 4px;
    }
</style>