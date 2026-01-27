<?php

use app\models\ProductionLog;
?>
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4>Tracking Pesanan: #<?= $so->kode_permintaan ?></h4>
        </div>
        <div class="card-body">
            <h5>Status Saat Ini: <span class="badge badge-info"><?= $so->status_pesanan ?></span></h5>
            <hr>
            <?php
            foreach ($so->workOrder as $wo): ?>
                <div class="wo-item mb-4">
                    <h6>Produk: <?= $wo->produk->nama_barang ?> (Qty: <?= $wo->qty_target ?>)</h6>

                    <div class="stepper-wrapper">
                        <?php
                        $details = $wo->routing->details;
                        foreach ($details as $step):
                            $log = ProductionLog::findOne([
                                'id_wo' => $wo->id_wo,
                                'id_workcenter' => $step->workcenter_id
                            ]);

                            $class = "stepper-item";
                            if ($log && $log->status == 2) $class .= " completed";
                            elseif ($log && $log->status == 1) $class .= " active";
                        ?>
                            <div class="<?= $class ?>">
                                <div class="step-counter"></div>
                                <div class="step-name"><?= $step->workCenter->nama_workcenter ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>