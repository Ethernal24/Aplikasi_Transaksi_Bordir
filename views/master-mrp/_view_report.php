<h3 style="text-align: center;">LAPORAN KEBUTUHAN BARANG</h3>

<table class="table table-bordered" width="100%" border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>Nama Produk</th>
            <th>Nama Bahan</th>
            <th>Kebutuhan Kotor</th>
            <th>Stok Tersedia</th>
            <th>Kebutuhan Bersih</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($details)): ?>
            <?php foreach ($details as $model): ?>
                <tr>
                    <td><?= $model->produk->nama_barang ?? '-' ?></td>
                    <td><?= $model->bahan->nama_barang ?? '-' ?></td>
                    <td align="center"><?= $model->kebutuhan_kotor ?></td>
                    <td align="center"><?= $model->stock_tersedia ?? 0 ?></td>
                    <td align="center"><?= $model->kebutuhan_bersih ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" align="center">Data Tidak Ditemukan</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>