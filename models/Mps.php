<?php

namespace app\models;

use DateTime;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\web\Response;

/**
 * This is the model class for table "mps".
 *
 * @property int $mps_id
 * @property int $barang_id
 * @property int $periode
 * @property int $status_mps
 * @property string $tanggal_akhir
 * @property int $tanggal_awal
 * @property MpsDetail[] $mpsDetails
 */
class Mps extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mps';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'dibuat_pada',
                'updatedAtAttribute' => 'diperbarui_pada',
                'value' => new Expression('NOW()'), // gunakan CURRENT_TIMESTAMP di DB
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_mps', 'periode', 'tanggal_awal', 'tanggal_akhir', 'status_mps', 'buffer_time', 'alokasi_mesin', 'alokasi_karyawan'], 'required'],
            [['status_mps', 'alokasi_mesin', 'alokasi_karyawan'], 'integer'],
            [['kode_mps'], 'string'],
            [['kode_mps'], 'unique'],
            [['buffer_time'], 'number'],

            ['tanggal_akhir', 'compare', 'compareAttribute' => 'tanggal_awal', 'operator' => '>=', 'enableClientValidation' => true],

            // Validasi: tanggal_awal minimal hari ini
            ['tanggal_awal', 'compare', 'compareValue' => date('Y-m-d'), 'operator' => '>=', 'type' => 'date'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'mps_id' => 'Mps ID',
            'kode_mps' => 'Kode MPS',
            'periode' => 'Periode',
            'tanggal_akhir' => 'Tanggal Akhir',
            'tanggal_awal' => 'Tanggal Awal',
            'status_mps' => "Status MPS",
            'buffer_time' => "Buffer Time (%)",
        ];
    }

    public function getPermintaan()
    {
        return $this->hasOne(PermintaanPelanggan::class, ['permintaan_id' => 'sumber']);
    }

    public function getBarang()
    {
        return $this->hasOne(Barang::class, ['barang_id' => 'barang_id']);
    }

    public function getStatusLabel()
    {
        $status = [
            '0' => ['label' => 'Draft', 'class' => 'badge bg-info'],
            '1' => ['label' => 'Approve', 'class' => 'badge bg-success'],
        ];
        return isset($status[$this->status_mps]) ? $status[$this->status_mps] : ['label' => 'unknow', 'class' => 'badge bg-secondary'];
    }
    // public function getPrioritasLabel()
    // {
    //     $status = [
    //         0 => ['label' => 'Low', 'class' => 'badge bg-info'],
    //         1 => ['label' => 'Normal', 'class' => 'badge bg-primary'],
    //         2 => ['label' => 'High', 'class' => 'badge bg-warning'],
    //         3 => ['label' => 'Urgent', 'class' => 'badge bg-danger'],
    //     ];
    //     return isset($status[$this->prioritas]) ? $status[$this->prioritas] : ['label' => 'unknow', 'class' => 'badge bg-secondary'];
    // }

    public function getMpsDetails()
    {
        return $this->hasMany(MpsDetail::class, ['mps_id' => 'mps_id']);
    }
    public function getMrp()
    {
        return $this->hasOne(MasterMrp::class, ['mps_id' => 'mps_id']);
    }
    public function getRouting()
    {
        return $this->hasOne(MasterRouting::class, ['routing_id' => 'routing_id']);
    }


    public static function hitungKapasitasShift()
    {
        // Panggil Model Shift
        $shifts = Shift::find()->all();
        $totalMenitHarian = 0;

        foreach ($shifts as $shift) {
            $totalMenitHarian += ($shift->jam_efektif * 60);
        }
        return $totalMenitHarian;
    }

    public static function hitungKapasitasBeban($routing_id, $qty)
    {
        $hitungKapasitas = 0;
        // Panggil Model RoutingDetail
        $details = RoutingDetail::find()
            ->where(['routing_id' => $routing_id])
            ->all();

        foreach ($details as $detail) {
            $hitungKapasitas += $detail->waktu_setup_menit + ($detail->standard_time_menit * $qty);
        }
        return $hitungKapasitas;
    }

    /**
     * Fungsi utama yang menyatukan semua hitungan
     */
    public static function getEstimasiSelesai($routing_id, $qty, $tanggal_awal)
    {
        // 1. Ambil semua langkah kerja (Routing Detail)
        $details = RoutingDetail::find()->where(['routing_id' => $routing_id])->all();
        $totalHariProduksi = 0;
        $kapasitasShift = self::hitungKapasitasShift();

        if ($kapasitasShift <= 0) return null;

        foreach ($details as $detail) {
            // 2. Ambil data stok resource riil (Karyawan atau Mesin)
            $wc = Workcenter::findOne($detail->workcenter_id);

            // Memanfaatkan fungsi getStatusKapasitas untuk ambil jumlah tersedia
            $analisa = self::getStatusKapasitas($detail->workcenter_id, 0, $wc->tipe_kapasitas);
            $jumlahResource = $analisa['tersedia'] > 0 ? $analisa['tersedia'] : 1; // Default 1 jika data kosong

            // 3. Hitung beban menit untuk proses ini
            $bebanProses = $detail->waktu_setup_menit + ($detail->standard_time_menit * $qty);

            // 4. Kapasitas GRUP per hari di WC ini (Shift * Jumlah Orang/Mesin)
            $kapasitasGrupHarian = $kapasitasShift * $jumlahResource;

            // 5. Hitung hari yang dibutuhkan (Pembulatan ke atas)
            $hariButuh = ceil($bebanProses / $kapasitasGrupHarian);

            // 6. Akumulasi hari (Asumsi proses manufaktur berurutan/sekuensial)
            $totalHariProduksi += $hariButuh;
        }

        // Mengembalikan tanggal selesai berdasarkan akumulasi hari
        return date('Y-m-d', strtotime("+$totalHariProduksi days", strtotime($tanggal_awal)));
    }
    public static function hitungKebutuhanResourcePerWC($routing_id, $qty, $tanggal_awal, $tanggal_akhir, $workcenter_id)
    {
        // 1. Ambil data Workcenter untuk cek tipe_kapasitas
        $wc = Workcenter::findOne($workcenter_id);
        if (!$wc) return 0;

        // 2. Ambil Beban Menit (Setup + (Standard Time * Qty))
        $bebanMenitWC = RoutingDetail::find()
            ->where(['routing_id' => $routing_id, 'workcenter_id' => $workcenter_id])
            ->sum('waktu_setup_menit + (standard_time_menit * ' . (int)$qty . ')');

        // 3. Hitung durasi hari kerja
        $tgl1 = new DateTime($tanggal_awal);
        $tgl2 = new DateTime($tanggal_akhir);
        $jumlahHari = $tgl1->diff($tgl2)->days + 1;

        // 4. Kapasitas 1 Resource (Mesin/Orang) dalam periode tsb
        $menitTersediaSatuResource = self::hitungKapasitasShift() * $jumlahHari;

        // 5. Hitung Kebutuhan
        if ($menitTersediaSatuResource > 0) {
            $kebutuhan = ceil($bebanMenitWC / $menitTersediaSatuResource);
            return [
                'jumlah' => $kebutuhan,
                'tipe' => ($wc->tipe_kapasitas == 1) ? 'Orang' : 'Mesin'
            ];
        }

        return ['jumlah' => 0, 'tipe' => 'N/A'];
    }
    public static function hitungKebutuhanSemuaWC($routing_id, $qty, $tanggal_awal, $tanggal_akhir)
    {
        $rekapKebutuhan = [];
        $listWC = RoutingDetail::find()
            ->select(['workcenter_id'])
            ->where(['routing_id' => $routing_id])
            ->distinct()
            ->all();

        foreach ($listWC as $row) {
            // A. Total Beban yang Dibutuhkan (Load)
            $bebanMenitWC = RoutingDetail::find()
                ->where(['routing_id' => $routing_id, 'workcenter_id' => $row->workcenter_id])
                ->sum('waktu_setup_menit + (standard_time_menit * ' . (int)$qty . ')');

            // B. Kapasitas Maksimal Tersedia dalam Rentang Waktu (Capacity)
            $maksKapasitas = self::hitungMaksimalKapasitasTersedia($tanggal_awal, $tanggal_akhir, $row->workcenter_id);

            // C. Hitung Utilisasi (%)
            $utilisasi = ($maksKapasitas > 0) ? round(($bebanMenitWC / $maksKapasitas) * 100, 2) : 0;

            $wc = Workcenter::findOne($row->workcenter_id);
            $resource = self::hitungKebutuhanResourcePerWC($routing_id, $qty, $tanggal_awal, $tanggal_akhir, $row->workcenter_id);
            $analisa = self::getStatusKapasitas($row->workcenter_id, $resource['jumlah'], $wc->tipe_kapasitas);

            $rekapKebutuhan[$row->workcenter_id] = [
                'nama_wc' => $wc->nama_workcenter,
                'total_beban_menit' => $bebanMenitWC,
                'maks_kapasitas_menit' => $maksKapasitas,
                'utilisasi_persen' => $utilisasi,
                'kebutuhan_jumlah' => $resource['jumlah'],
                'kebutuhan_tipe' => $resource['tipe'],
                'stok_riil' => $analisa['tersedia'],
                'warna' => $analisa['warna'],
                'status' => ($utilisasi <= 100) ? 'AMAN' : 'OVERLOAD'
            ];
        }
        return $rekapKebutuhan;
    }

    public static function getStatusKapasitas($workcenter_id, $kebutuhan_jumlah, $tipe_kapasitas)
    {
        $stokTersedia = 0;

        if ($tipe_kapasitas == 1) { // Orang
            $stokTersedia = TenagaKerja::find()
                ->where(['workcenter_id' => $workcenter_id, 'status_kerja' => 'Aktif'])
                ->count();
        } else { // Mesin
            $stokTersedia = Mesin::find()
                ->where(['workcenter_id' => $workcenter_id, 'status_mesin' => 'Ready'])
                ->count();
        }

        $selisih = $stokTersedia - $kebutuhan_jumlah;

        return [
            'tersedia' => $stokTersedia,
            'selisih' => $selisih,
            'status' => ($selisih >= 0) ? 'AMAN' : 'OVERLOAD',
            'warna' => ($selisih >= 0) ? 'green' : 'red'
        ];
    }
    public static function hitungMaksimalKapasitasTersedia($tanggal_awal, $tanggal_akhir, $workcenter_id)
    {
        // 1. Hitung durasi hari kerja dalam rentang waktu
        $tgl1 = new DateTime($tanggal_awal);
        $tgl2 = new DateTime($tanggal_akhir);
        $jumlahHari = $tgl1->diff($tgl2)->days + 1;

        // 2. Ambil data Workcenter & jumlah resource riil
        $wc = Workcenter::findOne($workcenter_id);
        if (!$wc) return 0;

        // Gunakan fungsi yang sudah kita simpan sebelumnya untuk cek stok riil
        $analisa = self::getStatusKapasitas($workcenter_id, 0, $wc->tipe_kapasitas);
        $jumlahResource = $analisa['tersedia'];

        // 3. Kapasitas Maksimal = Menit Shift * Jumlah Resource * Jumlah Hari
        $kapasitasShift = self::hitungKapasitasShift();

        return $kapasitasShift * $jumlahResource * $jumlahHari;
    }
}
