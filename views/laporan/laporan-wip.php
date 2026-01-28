<?php

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Laporan WIP (Work In Progress)';

// Inisialisasi Kolom Standar
$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
    [
        'attribute' => 'kode_wo',
        'format' => 'raw',
        'value' => function ($model) {
            return Html::a($model->kode_wo, ['view', 'id' => $model->id_wo], ['class' => 'text-bold']);
        }
    ],
    'produk.nama_barang', // Mengasumsikan ada relasi 'product' di model WorkOrder
    'qty_target',
];

// Menambahkan Kolom Dinamis Berdasarkan Routing (Workcenter)
foreach ($workcenters as $wc) {
    $gridColumns[] = [
        'label' => $wc->nama_workcenter,
        'headerOptions' => ['style' => 'background-color: #f4f4f4; text-align: center;'],
        'contentOptions' => ['style' => 'text-align: center;'],
        'value' => function ($model) use ($wc) {
            // Memanggil fungsi hitung output di model WorkOrder
            return $model->getOutputByWorkcenter($wc->workcenter_id);
        },
    ];
}

// Menambahkan Kolom Kalkulasi Akhir
$gridColumns[] = [
    'label' => 'Total WIP',
    'headerOptions' => ['class' => 'bg-warning'],
    'value' => function ($model) {
        // WIP = Target - Output di Proses Terakhir (Finishing)
        // Anda perlu menyesuaikan ID workcenter Finishing Anda
        $outputAkhir = $model->getOutputByWorkcenter(4); // Misal ID 4 adalah Finishing
        return $model->qty_target - $outputAkhir;
    }
];

$gridColumns[] = [
    'label' => 'Progress',
    'format' => 'raw',
    'value' => function ($model) {
        $outputAkhir = $model->getOutputByWorkcenter(4);
        $pct = ($model->qty_target > 0) ? round(($outputAkhir / $model->qty_target) * 100, 1) : 0;
        $color = $pct >= 100 ? 'bg-success' : 'bg-primary';

        return '
            <div class="progress progress-xs" style="margin-bottom: 0;">
                <div class="progress-bar ' . $color . '" style="width: ' . $pct . '%"></div>
            </div>
            <small>' . $pct . '%</small>
        ';
    }
];
?>

<div class="pc-content">
    <div class="card table-card">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="card-body mx-4">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => $gridColumns,
                'tableOptions' => ['class' => 'table table-bordered table-striped'],
            ]); ?>
        </div>
    </div>
</div>