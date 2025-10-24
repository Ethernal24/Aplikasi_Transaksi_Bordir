<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\MasterMrp $model */

$this->title = 'Detail MRP : ' . $model->mrp_id;
$this->params['breadcrumbs'][] = ['label' => 'Master Mrps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pc-content">
    <div class="card card-table">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="row mx-3">
            <div class="col">
                <div>
                    <strong>Nama Barang : </strong>
                    <?= $model->mps->barangName ?>
                </div>
                <div>
                    <strong>Tipe : </strong>
                    <?= $model->mps->tipeLabel ?>
                </div>
            </div>
        </div>
        <div class="card-body">

            <?= Html::a('Update', ['update', 'mrp_id' => $model->mrp_id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'mrp_id' => $model->mrp_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
            <?= Html::a('Back', ['index'], ['class' => 'btn btn-secondary']) ?>
        </div>
    </div>


    <p>

    </p>


</div>