<?php

use app\models\WorkorderMaterial;
use yii\grid\GridView;
?>
<div class="pt-3">
    <h5>Kebutuhan Bahan Baku (MRP Result)</h5>
    <?= GridView::widget([
        'dataProvider' => new \yii\data\ActiveDataProvider([
            'query' => $model->getWoMat(),
        ]),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            // 'wo_id',
            [
                'attribute' => 'bahan_id',
                'label' => 'Nama Bahan',
                'value' => 'bahan.nama_barang',
            ],
            'qty_plan',
            'qty_aktual',
            [
                'attribute' => 'status_pengambilan_bahan',
                'label' => 'Status Pengambilan Barang',
                'format' => 'raw',
                'value' => function ($m) {
                    $color = ($m->qty_aktual >= $m->qty_plan) ? 'success' : 'warning';
                    return "<span class='badge bg-{$color}'>Ready</span>";
                }
            ],
        ],
    ]) ?>
</div>