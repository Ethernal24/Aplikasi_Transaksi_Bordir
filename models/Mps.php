<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

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
class Mps extends \yii\db\ActiveRecord
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
            [['kode_mps', 'periode', 'tanggal_awal', 'tanggal_akhir', 'status_mps'], 'required'],
            [['status_mps'], 'integer'],
            [['kode_mps'], 'string'],
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

    public function getMpsDetails()
    {
        return $this->hasMany(MpsDetail::class, ['mps_id' => 'mps_id']);
    }
    public function getMrp()
    {
        return $this->hasOne(MasterMrp::class, ['mps_id' => 'mps_id']);
    }
    public static function getActualCapacity($startDate, $endDate)
    {
        // 1. Hitung jumlah hari kerja (exclude hari libur jika ada)
        $start = new \DateTime($startDate);
        $end = new \DateTime($endDate);
        $days = $end->diff($start)->days + 1;

        // 2. Ambil jumlah karyawan aktif dari Master_Employee
        $employeeCount = TenagaKerja::find()->where(['status_kerja' => 0])->count();

        // 3. Ambil jumlah mesin aktif dari Master_Machine
        $machineCount = Mesin::find()->where(['status_mesin' => 0])->count();

        // Asumsi standar: 8 jam kerja = 480 menit
        $dailyMinutes = 480;

        return [
            'manpower_total' => $employeeCount * $dailyMinutes * $days,
            'machine_total' => $machineCount * $dailyMinutes * $days,
        ];
    }
}
