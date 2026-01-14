<?php
// Cari apakah ada log yang statusnya masih 'Started' untuk WO ini

use app\models\ProductionLog;
use yii\helpers\Html;

$currentLog = $model->getCurrentLog();

$nextWc = $model->getNextStep();
?>

<div class="production-control card shadow-sm p-4 text-center">
    <?php if ($currentLog): ?>
        <div class="mb-3">
            <span class="badge badge-warning p-2">SEDANG BERJALAN</span>
            <h3 class="mt-2"><?= $currentLog->workcenter->nama_workcenter ?></h3>
        </div>
        <?= Html::a('SELESAIKAN TAHAP INI', ['finish-production', 'id_log' => $currentLog->id_log], [
            'class' => 'btn btn-success btn-lg',
            'data-method' => 'post'
        ]) ?>

    <?php elseif ($nextWc): ?>
        <div class="mb-3">
            <span class="badge badge-secondary p-2">TAHAP SELANJUTNYA</span>
            <h3 class="mt-2"><?= $nextWc->workCenter->nama_workcenter ?></h3>
        </div>
        <?= Html::a('START PRODUKSI', ['start-production', 'id_wo' => $model->id_wo, 'wc_id' => $nextWc->workcenter_id], [
            'class' => 'btn btn-primary btn-lg',
            'data-method' => 'post'
        ]) ?>

    <?php else: ?>
        <div class="alert alert-success">
            <i class="fa fa-check-circle"></i> Produksi untuk Work Order ini telah selesai sepenuhnya.
        </div>
    <?php endif; ?>
</div>