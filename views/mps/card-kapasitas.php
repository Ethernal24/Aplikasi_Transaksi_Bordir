<?php

use yii\helpers\Html;

// 1. Hitung beban riil dari detail MPS yang tersimpan
$wcLoads = [];
// Pengali efisiensi dari header MPS
$multiplier = (1 / ($model->target_efisiensi / 100)) * (1 + ($model->buffer_time / 100));

foreach ($detail as $item) {
    // Pastikan relasi 'routing' ada di model MpsDetail
    if ($item->routing && $item->routing->details) {
        foreach ($item->routing->details as $rDetail) {
            $wcId = $rDetail->workcenter_id;
            // Rumus beban: (Qty * SMV * Efisiensi) + Setup
            $beban = ($item->qty_plan * $rDetail->standard_time_menit * $multiplier) + ($rDetail->setup_time_menit ?? 0);

            if (!isset($wcLoads[$wcId])) $wcLoads[$wcId] = 0;
            $wcLoads[$wcId] += $beban;
        }
    }
}
?>

<h4 class="mb-3">Analisis Kapasitas Produksi</h4>
<div class="row">
    <?php foreach ($capacityData as $id => $wc): ?>
        <?php
        $bebanRiil = $wcLoads[$id] ?? 0;
        $persenMan = $wc['cap_man'] > 0 ? ($bebanRiil / $wc['cap_man'] * 100) : 0;

        // Tentukan warna berdasarkan persentase
        $color = ($persenMan > 100) ? 'bg-danger' : (($persenMan > 80) ? 'bg-warning' : 'bg-success');
        ?>
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm border-left-<?= ($persenMan > 100) ? 'danger' : 'info' ?>">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-uppercase mb-1"><?= Html::encode($wc['nama']) ?></div>
                    <div class="d-flex justify-content-between align-items-center no-gutters">
                        <div class="col mr-2">
                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                <?= number_format($bebanRiil, 0, ',', '.') ?> / <?= number_format($wc['cap_man'], 0, ',', '.') ?> <small>Min</small>
                            </div>
                        </div>
                        <div class="col-auto">
                            <span class="badge <?= ($persenMan > 100) ? 'badge-danger' : 'badge-light' ?>">
                                <?= round($persenMan) ?>%
                            </span>
                        </div>
                    </div>

                    <div class="progress mt-2" style="height: 8px;">
                        <div class="progress-bar <?= $color ?>" role="progressbar"
                            style="width: <?= min($persenMan, 100) ?>%"></div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>