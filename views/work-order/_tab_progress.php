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
        <?= Html::a('SELESAIKAN TAHAP INI', ['finish-production', 'log_id' => $currentLog->id_log], [
            'class' => 'btn btn-success btn-lg',
            'data-method' => 'post'
        ]) ?>

    <?php elseif ($nextWc): ?>
        <div class="mb-3">
            <span class="badge badge-secondary p-2">TAHAP SELANJUTNYA</span>
            <h3 class="mt-2"><?= $nextWc->nama_workcenter ?></h3>
        </div>
        <?= Html::a('START PRODUKSI', ['start-production', 'wo_id' => $model->wo_id, 'wc_id' => $nextWc->id_workcenter], [
            'class' => 'btn btn-primary btn-lg',
            'data-method' => 'post'
        ]) ?>

    <?php else: ?>
        <div class="alert alert-success">
            <i class="fa fa-check-circle"></i> Produksi untuk Work Order ini telah selesai sepenuhnya.
        </div>
    <?php endif; ?>
</div>