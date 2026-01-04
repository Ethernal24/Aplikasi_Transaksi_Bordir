<?php

use yii\widgets\DetailView;
?>
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'kode_wo',
        [
            'attribute' => 'id_mps',
            'label' => 'Kode MPS',
            'value' => $model->mps->kode_mps,
        ],
        [
            'attribute' => 'permintaan_id',
            'label' => 'Kode Permintaan',
            'value' => $model->permintaan->kode_permintaan,
        ],
        [
            'attribute' => 'id_produk',
            'label' => 'Nama Produk',
            'value' => $model->produk->nama_barang,
        ],
        [
            'attribute' => 'id_routing',
            'label' => 'Kode Routing',
            'value' => $model->routing->kode_routing,
        ],
        'qty_target',
        'tanggal_wo:date',
        'due_date:date',
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
                $label = $model->labelPrioritas;
                return "<span class= '{$label['class']}'>{$label['label']}</span>";
            },
        ],
        'created_at',
        'updated_at',
    ],
]) ?>