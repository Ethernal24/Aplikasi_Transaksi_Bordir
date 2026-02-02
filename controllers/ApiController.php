<?php

namespace app\controllers;

use app\models\JadwalSimulasi;
use app\models\MasterRouting;
use app\models\Mps;
use app\models\RoutingDetail;
use app\models\Workcenter;
use DateTime;
use Yii;
use yii\web\Response;

class ApiController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionHitungEstimasi($produk_id = null, $routing_id = null, $qty = null, $tanggal_awal = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        // 1. Validasi minimal: Qty dan Tanggal tidak boleh kosong
        if (!$qty || !$tanggal_awal) {
            return ['status' => 'error', 'message' => 'Quantity dan Tanggal Mulai harus diisi!'];
        }

        // 2. Logika "Akali" Routing ID (Jika dari Simulasi, routing_id biasanya null)
        if (empty($routing_id) && !empty($produk_id)) {
            $routing = MasterRouting::find()
                ->where(['produk_id' => $produk_id])
                ->one();

            if ($routing) {
                $routing_id = $routing->routing_id;
            } else {
                return ['status' => 'error', 'message' => 'Routing untuk produk ini belum dibuat di Master Routing!'];
            }
        }

        // 3. Cek apakah akhirnya kita punya routing_id (baik dari parameter langsung atau hasil cari)
        if (empty($routing_id)) {
            return ['status' => 'error', 'message' => 'Data Routing tidak terdeteksi.'];
        }

        // 4. Eksekusi hitungan di Model
        $estimasi = Mps::getEstimasiSelesai($routing_id, $qty, $tanggal_awal);

        if ($estimasi) {
            $start = new DateTime($tanggal_awal);
            $end = new DateTime($estimasi);
            $durasi = $end->diff($start)->days;
            return [
                'status' => 'success',
                'estimasi_selesai' => $estimasi,
                'routing_id_used' => $routing_id,
                'durasi' => $durasi,
            ];
        }

        return ['status' => 'error', 'message' => 'Gagal menghitung estimasi. Periksa kapasitas shift atau data routing.'];
    }

    public function actionHitungQuantity($produk_id, $tanggal_awal, $tanggal_akhir)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $routing = MasterRouting::find()->where(['produk_id' => $produk_id])->one();
        if (!$routing) return ['status' => 'error', 'message' => 'Routing tidak ditemukan'];

        // Ambil kapasitas harian dari fungsi yang sudah ada di Model
        $kapasitasShift = Mps::hitungKapasitasShift();
        if ($kapasitasShift <= 0) return ['status' => 'error', 'message' => 'Shift belum diatur'];

        // Hitung selisih hari
        $start = new DateTime($tanggal_awal);
        $end = new DateTime($tanggal_akhir);
        $selisih = $end->diff($start)->days;

        $totalMenitTersedia = $kapasitasShift * $selisih;

        // Ambil data beban per unit dari Routing
        $totalStandard = 0;
        $totalSetup = 0;
        $details = RoutingDetail::find()->where(['routing_id' => $routing->routing_id])->all();
        foreach ($details as $d) {
            $totalStandard += $d->standard_time_menit;
            $totalSetup += $d->waktu_setup_menit;
        }

        if ($totalStandard <= 0) return ['status' => 'error', 'message' => 'Standard Time nol'];

        // Qty = (Menit Tersedia - Setup) / Standard Time
        $qtyMaksimal = floor(($totalMenitTersedia - $totalSetup) / $totalStandard);

        return [
            'durasi' => $selisih,
            'status' => 'success',
            'qty' => ($qtyMaksimal > 0) ? (int)$qtyMaksimal : 0
        ];
    }

    public function actionTestFinal()
    {
        // Data Simulasi Input
        $routing_id = 11;
        $qty = 150;
        $tgl_mulai = '2026-02-02';
        $tanggal_input = '2026-02-20'; // Rentang waktu 11 hari
        $estimasiSelesai = MPS::getEstimasiSelesai($routing_id, $qty, $tgl_mulai);
        // Memanggil fungsi rekap yang sudah menyertakan Utilisasi & Maks Kapasitas
        $kebutuhanWc = MPS::hitungKebutuhanSemuaWC($routing_id, $qty, $tgl_mulai, $estimasiSelesai);

        echo "<h3>HASIL ANALISA KAPASITAS PER WORKCENTER</h3>";
        echo "Routing ID: " . $routing_id . "<br>";
        echo "Quantity Target: <b>" . $qty . " pcs</b><br>";
        echo "Periode Kerja: " . $tgl_mulai . " s/d " . $estimasiSelesai . "<br><hr>";

        foreach ($kebutuhanWc as $id => $detail) {
            echo "<b>Workcenter: " . $detail['nama_wc'] . "</b><br>";

            // 1. Tampilkan Perbandingan Menit (Load vs Capacity)
            echo "Total Beban (Load): " . number_format($detail['total_beban_menit']) . " Menit<br>";
            echo "Kapasitas Maksimal (Capacity): " . number_format($detail['maks_kapasitas_menit']) . " Menit<br>";

            // 2. Tampilkan Persentase Pemakaian Kapasitas
            $warnaUtilisasi = ($detail['utilisasi_persen'] > 100) ? 'red' : 'blue';
            echo "Utilisasi Kapasitas: <b style='color: $warnaUtilisasi;'>" . $detail['utilisasi_persen'] . "%</b><br>";

            // 3. Tampilkan Resource yang Dibutuhkan vs Stok Riil
            echo "Kebutuhan Ideal: " . $detail['kebutuhan_jumlah'] . " " . $detail['kebutuhan_tipe'] . "<br>";
            echo "Stok Riil Tersedia: " . $detail['stok_riil'] . " " . $detail['kebutuhan_tipe'] . "<br>";

            // 4. Status Akhir
            echo "Status: <b style='color: " . $detail['warna'] . "'>" . $detail['status'] . "</b><br>";
            echo "-----------------------------------<br>";
        }
    }
    public function actionHitungKapasitasTotal()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $request = Yii::$app->request;
        $items = $request->post('items');
        $tgl_mulai = $request->post('tgl_mulai');
        $tgl_akhir = $request->post('tgl_akhir');

        if (empty($items) || !$tgl_mulai || !$tgl_akhir) {
            return [
                'status' => 'success',
                'html_cards' => '<div class="col-12 text-muted">Lengkapi data item dan tanggal untuk analisa.</div>'
            ];
        }

        $rekapWc = [];

        // 1. Loop semua item yang dikirim dari Grid MPS
        foreach ($items as $item) {
            $routing_id = $item['routing_id'];
            $qty = (int)$item['qty'];

            if (!$routing_id || $qty <= 0) continue;

            // Ambil detail routing untuk item ini
            $details = RoutingDetail::find()->where(['routing_id' => $routing_id])->all();

            foreach ($details as $d) {
                $wcId = $d->workcenter_id;

                // Hitung beban menit untuk baris ini
                $bebanMenit = $d->waktu_setup_menit + ($d->standard_time_menit * $qty);

                if (!isset($rekapWc[$wcId])) {
                    $wc = Workcenter::findOne($wcId);
                    // Hitung kapasitas maksimal sekali saja per WC
                    $maks = MPS::hitungMaksimalKapasitasTersedia($tgl_mulai, $tgl_akhir, $wcId);

                    $rekapWc[$wcId] = [
                        'nama_wc' => $wc->nama_workcenter,
                        'tipe_kapasitas' => $wc->tipe_kapasitas,
                        'total_beban' => 0,
                        'maks_kapasitas' => $maks,
                    ];
                }

                // Akumulasi beban menit (karena beberapa produk bisa masuk WC yang sama)
                $rekapWc[$wcId]['total_beban'] += $bebanMenit;
            }
        }

        // 2. Render HTML Cards berdasarkan hasil akumulasi
        $htmlCards = "";
        foreach ($rekapWc as $wcId => $data) {
            $utilisasi = ($data['maks_kapasitas'] > 0)
                ? round(($data['total_beban'] / $data['maks_kapasitas']) * 100, 2)
                : 0;

            // Gunakan fungsi hitung resource yang Anda buat
            // Kita hitung berdasarkan TOTAL beban menit yang sudah terakumulasi
            $kebutuhanResource = ($data['maks_kapasitas'] > 0)
                ? ceil($data['total_beban'] / ($data['maks_kapasitas'] / ($data['maks_kapasitas'] > 0 ? 1 : 1))) // Logic penyesuaian
                : 0;

            // Panggil getStatusKapasitas untuk cek stok riil (Orang/Mesin)
            $analisa = MPS::getStatusKapasitas($wcId, 0, $data['tipe_kapasitas']);

            $htmlCards .= $this->renderPartial('/mps/card-kapasitas', [
                'detail' => [
                    'nama_wc' => $data['nama_wc'],
                    'total_beban_menit' => $data['total_beban'],
                    'maks_kapasitas_menit' => $data['maks_kapasitas'],
                    'utilisasi_persen' => $utilisasi,
                    'stok_riil' => $analisa['tersedia'], // Jumlah Orang/Mesin yang ada di master
                    'kebutuhan_jumlah' => ceil($utilisasi / 100 * $analisa['tersedia']), // Estimasi kebutuhan resource
                    'kebutuhan_tipe' => ($data['tipe_kapasitas'] == 1) ? 'Orang' : 'Mesin',
                    'status' => ($utilisasi <= 100) ? 'AMAN' : 'OVERLOAD',
                    'warna' => ($utilisasi <= 100) ? '#28a745' : '#dc3545'
                ]
            ]);
        }

        return [
            'status' => 'success',
            'html_cards' => $htmlCards ?: '<div class="col-12 text-muted">Tidak ada beban terdeteksi.</div>'
        ];
    }
}
