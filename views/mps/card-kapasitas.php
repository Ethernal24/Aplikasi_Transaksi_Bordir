<?php
/* @var $detail array */
$borderClass = ($detail['status'] === 'OVERLOAD') ? 'border-danger' : 'border-success';
$badgeClass = ($detail['status'] === 'OVERLOAD') ? 'bg-danger' : 'bg-success';
?>

<div class="col-md-3 mb-3">
    <div class="card <?= $borderClass ?> shadow-sm h-100">
        <div class="card-header d-flex justify-content-between align-items-center bg-transparent">
            <h6 class="m-0 font-weight-bold text-primary"><?= $detail['nama_wc'] ?></h6>
            <span class="badge <?= $badgeClass ?> text-white"><?= $detail['status'] ?></span>
        </div>
        <div class="card-body mx-4">
            <p class="mb-1 text-muted small text-uppercase">Beban Kerja</p>
            <h4 class="mb-2"><?= number_format($detail['total_beban_menit']) ?> <small>Menit</small></h4>
            <div><?= number_format($detail['maks_kapasitas_menit']) ?></div>
            <div class="progress mb-2" style="height: 8px;">
                <div class="progress-bar" role="progressbar"
                    style="width: <?= $detail['utilisasi_persen'] ?>%; background-color: <?= $detail['warna'] ?>"
                    aria-valuenow="<?= $detail['utilisasi_persen'] ?>" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="row small mt-3">
                <div class="col-6 text-muted">Utilisasi: <b><?= $detail['utilisasi_persen'] ?>%</b></div>
                <div class="col-6 text-muted">Kebutuhan Ideal : <b><?= $detail['kebutuhan_jumlah'] . " " . $detail['kebutuhan_tipe'] ?></b></div>
            </div>
            <div class="row small">
                <div class="col-12 text-right text-muted text-end">Resource: <b><?= $detail['stok_riil'] ?> <?= $detail['kebutuhan_tipe'] ?></b></div>
            </div>
        </div>
    </div>
</div>