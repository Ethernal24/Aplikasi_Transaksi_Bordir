<?php

use yii\helpers\Url;
use yii\helpers\Html;

$roleName = Yii::$app->user->identity->roleName;

$dashboardUrl = Url::to(['site/index']);
$UserUrl = Url::to(['/user/index']);
$KaryawanUrl = Url::to(['/tenaga-kerja/index']);
$PelangganUrl = Url::to(['/master-pelanggan/index']);
$BahanUrl = Url::to(['/barang/index']);
$MpsUrl = Url::to(['/mps/index']);
$MrpUrl = Url::to(['/master-mrp/index']);
$MrpDetailUrl = Url::to(['/mrp-detail/index']);
$RoutingUrl = Url::to(['/master-routing/index']);
$ProdukUrl = Url::to(['/barang/index-barang-jadi']);
$SupplierUrl = Url::to(['/supplier/index']);
$UnitUrl = Url::to(['/unit/index']);
$MesinUrl = Url::to(['/mesin/index']);
$ReportUrl = Url::to(['/report/index']);
$StockUrl = Url::to(['/stock/index']);
$ShifttUrl = Url::to(['/shift/index']);
$laproUrl = Url::to(['/laporan-produksi/index']);
$lapagreUrl = Url::to(['/laporan-agregat/index']);
$lapkelUrl = Url::to(['/laporan-keluar/index']);
$PembelianUrl = Url::to(['/pembelian/index']);
$InvoiceUrl = Url::to(['/pembelian-detail/index']);
$PenggunaanUrl = Url::to(['/penggunaan/index']);
$SuratJalanUrl = Url::to(['/surat-jalan/index']);
$GudangUrl = Url::to(['/gudang/index']);
$PemesananUrl = Url::to(['/pemesanan/index']);
$PesanDetailUrl = Url::to(['/pesan-detail/index']);
$PanduanUrl = Url::to(['/site/panduan']);
$PenggunaanUrl = Url::to(['/penggunaan/index']);
$SuratJalanUrl = Url::to(['/surat-jalan/index']);
$GudangUrl = Url::to(['/gudang/index']);
$PemesananUrl = Url::to(['/pemesanan/index']);
$PermintaanPelangganUrl = Url::to(['/permintaan-pelanggan/index']);
$JenisUrl = Url::to(['/jenis/index']);
$BarangProUrl = Url::to(['/barangproduksi/index']);
$NotaUrl = Url::to(['/nota/index']);
$ForecastUrl = Url::to(['/riwayat-permintaan/index']);
$WorkOrderUrl = Url::to(['/work-order/index']);
$WorkCenterUrl = Url::to(['/workcenter/index']);
$KehadiranUrl = Url::to(['/kehadiran/index']);
$ProductionLogUrl = Url::to(['/production-log/index']);
$JadwalHarianUrl = Url::to(['/production-log-worker-assignment/index']);



$typographyUrl = Url::to(['site/typography']);
$colorUrl = Url::to(['site/color']);
$iconsUrl = Url::to(['site/icons']);
$loginUrl = Url::to(['site/login']);
$registerUrl = Url::to(['site/register']);
$samplePageUrl = Url::to(['site/sample-page']);
?>

<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="<?= $dashboardUrl ?>" class="b-brand text-primary" style="margin-bottom:5px; margin-top:20px;">
                <img src="<?= Yii::getAlias('@web') ?>/assets/images/diwarna_logo.png" alt="logo image" class="logo-lg d-flex" style="width:90%">
            </a>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">
                <li class="pc-item pc-caption">
                    <label>Navigation</label>
                </li>
                <?php if ($roleName === 'Super Admin'): ?>
                    <li class="pc-item">
                        <a href="<?= $dashboardUrl ?>" class="pc-link">
                            <span class="pc-micon"><i class="ph ph-gauge"></i></span>
                            <span class="pc-mtext">Dashboard</span>
                        </a>
                    </li>

                    <li class="pc-item">
                        <a href="<?= $UserUrl ?>" class="pc-link">
                            <span class="pc-micon"><i class="ph ph-user"></i></span>
                            <span class="pc-mtext">Akun</span>
                        </a>
                    </li>
                    <li class="pc-item pc-hasmenu">
                        <a href="#!" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph ph-user"></i>
                            </span>
                            <span class="pc-mtext">Karyawan</span>
                            <span class="pc-arrow">
                                <i data-feather="chevron-right"></i>
                            </span>
                        </a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a href="<?= $KaryawanUrl ?>" class="pc-link">Daftar Karyawan</a></li>
                            <li class="pc-item"><a href="<?= $ShifttUrl ?>" class="pc-link">Daftar Shift</a></li>
                            <li class="pc-item"><a href="<?= $KehadiranUrl ?>" class="pc-link">Absensi Karyawan</a></li>
                            <li class="pc-item"><a href="<?= $JadwalHarianUrl ?>" class="pc-link">Jadwal Shift Karyawan</a></li>
                        </ul>
                    </li>

                    <li class="pc-item pc-hasmenu">
                        <a href="#!" class="pc-link">
                            <span class="pc-micon">
                                <i class="fi fi-ts-box-alt"></i>
                            </span>
                            <span class="pc-mtext">Master Barang</span>
                            <span class="pc-arrow">
                                <i data-feather="chevron-right">
                                </i>
                            </span>
                        </a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link" href="<?= $BahanUrl ?>">Bahan Baku</a></li>
                            <li class="pc-item"><a class="pc-link" href="<?= $ProdukUrl ?>">Produk</a></li>

                        </ul>
                    </li>
                    <li class="pc-item pc-hasmenu">
                        <a href="#!" class="pc-link"><span class="pc-micon">
                                <i class="fi fi-ts-box-alt"></i> </span><span class="pc-mtext">Penjualan</span><span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link" href="<?= $PelangganUrl ?>">Daftar Pelanggan</a></li>
                            <li class="pc-item"><a class="pc-link" href="<?= $PermintaanPelangganUrl ?>">Data Permintaan Pelanggan</a></li>
                            <li class="pc-item"><a class="pc-link" href="<?= $ForecastUrl ?>">Riwayat Penjualan</a></li>

                        </ul>
                    </li>



                    <li class="pc-item pc-hasmenu">
                        <a href="#!" class="pc-link"><span class="pc-micon">
                                <i class="fi fi-ts-dolly-flatbed-alt"></i> </span><span class="pc-mtext">Pembelian</span><span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link" href="<?= $PembelianUrl ?>">Riwayat Pembelian Bahan Produksi</a></li>
                            <!-- <li class="pc-item"><a class="pc-link" href="<?= $InvoiceUrl ?>">Detail Pembelian Bahan Produksi</a></li> -->
                            <!-- <li class="pc-item"><a class="pc-link" href="">Report Barang</a></li> -->
                        </ul>
                    </li>

                    <li class="pc-item pc-hasmenu">
                        <a href="#!" class="pc-link">
                            <span class="pc-micon"><i class="fi fi-ts-box-alt"></i></span>
                            <span class="pc-mtext">Produksi</span>
                            <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                        <ul class="pc-submenu">
                            <li class="pc-item pc-hasmenu">
                                <a href="#!" class="pc-link">
                                    <span class="pc-mtext">Perencanaan Produksi</span>
                                    <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                                </a>
                                <ul class="pc-submenu">
                                    <li class="pc-item"><a class="pc-link" href="<?= $MpsUrl ?>">MPS</a></li>
                                    <li class="pc-item"><a class="pc-link" href="<?= $MrpUrl ?>">MRP</a></li>
                                </ul>
                            </li>
                            <li class="pc-item"><a class="pc-link" href="<?= $WorkCenterUrl ?>">Work Center</a></li>
                            <li class="pc-item"><a class="pc-link" href="<?= $RoutingUrl ?>">Routing</a></li>
                            <li class="pc-item"><a class="pc-link" href="<?= $UnitUrl ?>">Unit</a></li>

                            <li class="pc-item pc-hasmenu">
                                <a href="#!" class="pc-link">
                                    <span class="pc-mtext">Transaksi Bahan</span>
                                    <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                                </a>
                                <ul class="pc-submenu">
                                    <li class="pc-item"><a class="pc-link" href="<?= $PenggunaanUrl ?>">Penggunaan Bahan</a></li>
                                    <li class="pc-item"><a class="pc-link" href="<?= $StockUrl ?>">Stock Produksi</a></li>
                                </ul>
                            </li>
                            <li class="pc-item"><a class="pc-link" href="<?= $WorkOrderUrl ?>">Work Order</a></li>
                            <li class="pc-item"><a class="pc-link" href="<?= $ProductionLogUrl ?>">Log Produksi</a></li>
                            <li class="pc-item pc-hasmenu">
                                <a href="#!" class="pc-link">
                                    <span class="pc-mtext">Laporan Produksi</span>
                                    <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                                </a>
                                <ul class="pc-submenu">
                                    <li class="pc-item"><a class="pc-link" href="#">Laporan Besar</a></li>
                                    <li class="pc-item"><a class="pc-link" href="#">Laporan Workcenter</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="pc-item pc-hasmenu">
                        <a href="#!" class="pc-link"><span class="pc-micon">
                                <i class="fi fi-ts-box-alt"></i> </span><span class="pc-mtext">Gudang</span><span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link" href="<?= $PemesananUrl ?>">Riwayat Pemesanan Bahan Produksi</a></li>
                            <li class="pc-item"><a class="pc-link" href="<?= $GudangUrl ?>">Stock Gudang</a></li>

                        </ul>
                    </li>



                    <!-- <li class="pc-item">
                        <a href="<?= $StockUrl ?>" class="pc-link">
                            <span class="pc-micon"><i class="fi fi-ts-box-alt"></i></i></span>
                            <span class="pc-mtext">Stock</span>
                        </a>
                    </li> -->

                    <li class="pc-item">
                        <a href="<?= $SupplierUrl ?>" class="pc-link">
                            <span class="pc-micon"><i class="fi fi-ts-supplier-alt"></i></i></span>
                            <span class="pc-mtext">Supplier</span>
                        </a>
                    </li>

                    <!-- <li class="pc-item">
                        <a href="<?= $UnitUrl ?>" class="pc-link">
                            <span class="pc-micon"><i class="fi fi-ts-ruler-vertical"></i></span>
                            <span class="pc-mtext">Unit</span>
                        </a>
                    </li> -->

                    <li class="pc-item">
                        <a href="<?= $MesinUrl ?>" class="pc-link">
                            <span class="pc-micon"><i class="fi fi-ts-conveyor-belt"></i></span>
                            <span class="pc-mtext">Mesin</span>
                        </a>
                    </li>
                    <li class="pc-item">
                        <a href="<?= $ShifttUrl ?>" class="pc-link">
                            <span class="pc-micon"><i class="fi fi-ts-calendar-shift-swap"></i></span>
                            <span class="pc-mtext">Shift</span>
                        </a>
                    </li>


                    <li class="pc-item pc-hasmenu">
                        <a href="#!" class="pc-link"><span class="pc-micon">
                                <i class="fi fi-ts-ballot-check"></i> </span><span class="pc-mtext">Report</span><span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link" href="<?= $laproUrl ?>">Laporan Produksi</a></li>
                            <li class="pc-item"><a class="pc-link" href="<?= $lapagreUrl ?>">Laporan Agregat</a></li>
                            <li class="pc-item"><a class="pc-link" href="<?= $lapkelUrl ?>">Laporan Keluar</a></li>
                            <li class="pc-item"><a class="pc-link" href="<?= $JenisUrl ?>">Jenis</a></li>
                            <li class="pc-item"><a class="pc-link" href="<?= $BarangProUrl ?>">Barang Produksi</a></li>
                            <li class="pc-item"><a class="pc-link" href="<?= $NotaUrl ?>">Nota</a></li>
                        </ul>
                    </li>

                    <li class="pc-item">
                        <a href="<?= $PanduanUrl ?>" class="pc-link">
                            <span class="pc-micon"><i class="fi fi-ts-book"></i></span>
                            <span class="pc-mtext">Panduan</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if ($roleName === 'Admin'): ?>
                    <li class="pc-item">
                        <a href="<?= $dashboardUrl ?>" class="pc-link">
                            <span class="pc-micon"><i class="ph ph-gauge"></i></span>
                            <span class="pc-mtext">Dashboard</span>
                        </a>
                    </li>


                    <li class="pc-item pc-hasmenu">
                        <a href="#!" class="pc-link"><span class="pc-micon">
                                <i class="fi fi-ts-dolly-flatbed-alt"></i> </span><span class="pc-mtext">Pembelian</span><span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link" href="<?= $BarangUrl ?>">List Barang</a></li>
                            <li class="pc-item"><a class="pc-link" href="<?= $PembelianUrl ?>">Riwayat Pembelian Bahan Produksi</a></li>
                        </ul>
                    </li>
                    <li class="pc-item">
                        <a href="<?= $SupplierUrl ?>" class="pc-link">
                            <span class="pc-micon"><i class="fi fi-ts-supplier-alt"></i></i></span>
                            <span class="pc-mtext">Supplier</span>
                        </a>
                    </li>
                <?php endif; ?>


                <?php if ($roleName === 'Operator'): ?>
                    <li class="pc-item">
                        <a href="<?= $dashboardUrl ?>" class="pc-link">
                            <span class="pc-micon"><i class="ph ph-gauge"></i></span>
                            <span class="pc-mtext">Dashboard</span>
                        </a>
                    </li>

                    <li class="pc-item pc-hasmenu">
                        <a href="#!" class="pc-link"><span class="pc-micon">
                                <i class="fi fi-ts-box-alt"></i> </span><span class="pc-mtext">Gudang</span><span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link" href="<?= $PemesananUrl ?>">Riwayat Pemesanan Bahan Produksi</a></li>
                            <li class="pc-item"><a class="pc-link" href="<?= $GudangUrl ?>">Stock Gudang</a></li>

                        </ul>
                    </li>
                    <li class="pc-item">
                        <a href="<?= $MesinUrl ?>" class="pc-link">
                            <span class="pc-micon"><i class="fi fi-ts-conveyor-belt"></i></span>
                            <span class="pc-mtext">Mesin</span>
                        </a>
                    </li>
                    <li class="pc-item">
                        <a href="<?= $ShifttUrl ?>" class="pc-link">
                            <span class="pc-micon"><i class="fi fi-ts-calendar-shift-swap"></i></span>
                            <span class="pc-mtext">Shift</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>