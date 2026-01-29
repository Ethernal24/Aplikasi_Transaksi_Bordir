<?php

use app\models\ProductionLog;

$statusData = $so->getLabel();
$this->title = 'Tracking Pesanan ' . $so->kode_permintaan;
?>

<style>
    /* Kontainer Utama Stepper */
    .stepper-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin: 40px 0;
        position: relative;
    }

    .stepper-item {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        flex: 1;
        transition: all 0.3s ease;
    }

    /* Garis Penghubung */
    .stepper-item::before {
        position: absolute;
        content: "";
        border-bottom: 3px solid #ebedec;
        width: 100%;
        top: 20px;
        left: -50%;
        z-index: 2;
    }

    .stepper-item::after {
        position: absolute;
        content: "";
        border-bottom: 3px solid #ebedec;
        width: 100%;
        top: 20px;
        left: 50%;
        z-index: 2;
    }

    .stepper-item:first-child::before,
    .stepper-item:last-child::after {
        content: none;
    }

    /* Lingkaran Step */
    .step-counter {
        position: relative;
        z-index: 5;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #fff;
        border: 3px solid #ebedec;
        margin-bottom: 10px;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .step-name {
        color: #8a8a8a;
        font-size: 13px;
        font-weight: 600;
        text-align: center;
        text-transform: uppercase;
    }

    /* Status: COMPLETED (Selesai) */
    .stepper-item.completed .step-counter {
        background-color: #4caf50;
        border-color: #4caf50;
        color: white;
    }

    .stepper-item.completed .step-counter::after {
        content: "✔";
        font-size: 16px;
    }

    .stepper-item.completed .step-name {
        color: #4caf50;
    }

    .stepper-item.completed::before,
    .stepper-item.completed::after {
        border-color: #4caf50;
    }

    /* Status: ACTIVE (Sedang Berjalan) */
    .stepper-item.active .step-counter {
        background-color: #fff;
        border-color: #2196f3;
        color: #2196f3;
        box-shadow: 0 0 0 4px rgba(33, 150, 243, 0.2);
    }

    .stepper-item.active .step-name {
        color: #2196f3;
        font-weight: bold;
    }

    /* Animasi Pulse untuk Active */
    .stepper-item.active .step-counter {
        animation: pulse-blue 2s infinite;
    }

    @keyframes pulse-blue {
        0% {
            transform: scale(0.95);
            box-shadow: 0 0 0 0 rgba(33, 150, 243, 0.7);
        }

        70% {
            transform: scale(1);
            box-shadow: 0 0 0 10px rgba(33, 150, 243, 0);
        }

        100% {
            transform: scale(0.95);
            box-shadow: 0 0 0 0 rgba(33, 150, 243, 0);
        }
    }
</style>

<div class="pc-content">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom py-3">
            <div class="row">
                <div class="col-xl-4">
                    <h5 class="mb-0">Tracking Pesanan: <span class="text-primary">#<?= $so->kode_permintaan ?></span></h5>
                </div>
                <div class="col-xl-4">
                    <h5 class="mb-0">Nama Pemesan: <span class="text-black"><?= $so->pelanggan->nama_pelanggan ?></span></h5>
                </div>
                <div class="col-xl-4">
                    <h5>Status Pesanan :
                        <span class="badge p-2 <?= $statusData['class'] ?>">
                            <?= strtoupper($statusData['label']) ?>
                        </span>
                    </h5>

                </div>
            </div>
            <div class="row">
                <div class="col-xl-4">
                    <h5 class="mb-0">Tanggal Permintaan: <span class="text-primary">#<?= $so->tanggal_permintaan ?></span></h5>
                </div>
                <div class="col-xl-4">
                    <h5 class="mb-0">Tenggat Waktu: <span class="text-black"><?= $so->tenggat_waktu ?></span></h5>
                </div>
            </div>
        </div>

        <div class="card-body p-4">
            <?php foreach ($so->workOrder as $wo): ?>
                <div class="wo-card mb-5 p-3 border rounded">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="text-dark fw-bold mb-1">
                                <i class="fas fa-box me-2 text-primary"></i><?= $wo->produk->nama_barang ?>
                            </h6>

                            <?php
                            // Mencari data MPS Detail yang sesuai dengan id_wo saat ini
                            $currentMps = null;
                            foreach ($so->mpsDetail as $mps) {
                                if ($mps->produk_id == $wo->id_produk) {
                                    $currentMps = $mps;
                                    break;
                                }
                            }
                            ?>

                            <?php if ($currentMps && $currentMps->estimasi_selesai): ?>
                                <span class="badge bg-light-info text-info border border-info-subtle">
                                    <i class="far fa-clock me-1"></i>
                                    Estimasi Selesai: <?= date('d M Y', strtotime($currentMps->estimasi_selesai)) ?>
                                </span>
                            <?php else: ?>
                                <span class="text-muted small italic">Jadwal belum diatur</span>
                            <?php endif; ?>
                        </div>

                        <div class="text-end">
                            <span class="text-muted d-block small">Target Produksi</span>
                            <span class="badge bg-dark"><?= $wo->qty_target ?> Pcs</span>
                        </div>
                    </div>

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
                            elseif ($log && $log->status == 0) $class .= " active";
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