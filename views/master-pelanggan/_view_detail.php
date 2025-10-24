<table class="table table-sm">
    <thead>
        <tr>
            <th>#</th>
            <th>Bahan</th>
            <th>Qty per Unit</th>
            <th>Unit</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($bomList)): ?>
            <?php foreach ($bomList as $index => $bom): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars($bom->bahan->nama_barang ?? '-') ?></td>
                    <td><?= $bom->qty_per_unit ?></td>
                    <td><?= htmlspecialchars($bom->unit->satuan ?? '-') ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3" class="text-center text-muted">Belum ada data BOM.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>