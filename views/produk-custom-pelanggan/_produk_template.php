<tr class="produk-row" data-index="__INDEX__">
    <td class="align-middle">__INDEX__</td>
    <td><input type="text" name="ProdukCustomPelanggan[__INDEX__][kode_barang]" class="form-control" readonly></td>
    <td><input type="text" name="ProdukCustomPelanggan[__INDEX__][nama_barang_custom]" class="form-control"></td>
    <td class="text-center">
        <button type="button" class="btn btn-sm btn-primary toggle-bom" data-target="#bom-__INDEX__">
            <i class="fa fa-list"></i> BOM
        </button>
        <button type="button" class="btn btn-sm btn-success add-produk"><i class="fa fa-plus"></i></button>
        <button type="button" class="btn btn-sm btn-danger remove-produk"><i class="fa fa-trash"></i></button>
    </td>
</tr>
<tr id="bom-__INDEX__" class="bom-row" data-index="__BOM__" style="display:none;">
    <td colspan="4">
        <div class="bom-wrapper">
            <table class="table table-bordered table-sm table-striped bom-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Bahan</th>
                        <th>Kuantitas</th>
                        <th>Satuan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bom-item">
                        <td class="align-middle">1</td>
                        <td>
                            <select type="text" name="BomCustom[__INDEX__][0][bahan_id]" class="form-control">
                                <option value="">Pilih Barang</option>
                                <?= $bahanOption ?>
                            </select>
                        </td>
                        <td><input type="text" name="BomCustom[__INDEX__][0][qty_per_unit]" class="form-control"></td>
                        <td>
                            <select type="text" name="BomCustom[__INDEX__][0][unit_id]" class="form-control">
                                <option value="">Pilih Satuan</option>
                                <?= $optionsHtml ?>
                            </select>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-success add-bom"><i class="fa fa-plus"></i></button>
                            <button type="button" class="btn btn-sm btn-danger remove-bom"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </td>
</tr>