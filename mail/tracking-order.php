<?php

use yii\helpers\Html;
?>
<div style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: auto; border: 1px solid #eee; padding: 20px;">
    <h2 style="color: #2196f3; text-align: center;">Pesanan Anda Mulai Diproses!</h2>
    <p>Halo, <strong><?= Html::encode($so->pelanggan->nama_pelanggan) ?></strong>,</p>
    <p>Pesanan Anda dengan kode <strong>#<?= $so->kode_permintaan ?></strong> saat ini telah masuk ke tahap produksi.</p>

    <div style="background: #f9f9f9; padding: 15px; border-radius: 8px; margin: 20px 0; text-align: center;">
        <p style="margin-bottom: 10px;">Gunakan tombol di bawah ini untuk memantau progres produksi secara real-time:</p>
        <?= Html::a('Pantau Progres Pesanan', $trackingLink, [
            'style' => 'background-color: #2196f3; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; display: inline-block; font-weight: bold;'
        ]) ?>
    </div>

    <p style="font-size: 12px; color: #777; text-align: center;">
        Tenggat waktu pengerjaan: <?= date('d M Y', strtotime($so->tenggat_waktu)) ?><br>
        Terima kasih telah mempercayai layanan kami.
    </p>
</div>