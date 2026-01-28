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
            [['kode_mps', 'periode', 'tanggal_awal', 'tanggal_akhir', 'status_mps', 'buffer_time', 'prioritas'], 'required'],
            [['status_mps', 'prioritas', 'shift_id'], 'integer'],
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
            'target_efisiensi' => "Target Efisiens (%)",
            'prioritas' => "Prioritas",
            'shift_id' => "Shift ID",
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
    public function getPrioritasLabel()
    {
        $status = [
            0 => ['label' => 'Low', 'class' => 'badge bg-info'],
            1 => ['label' => 'Normal', 'class' => 'badge bg-primary'],
            2 => ['label' => 'High', 'class' => 'badge bg-warning'],
            3 => ['label' => 'Urgent', 'class' => 'badge bg-danger'],
        ];
        return isset($status[$this->prioritas]) ? $status[$this->prioritas] : ['label' => 'unknow', 'class' => 'badge bg-secondary'];
    }

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

    public function getShift()
    {
        return $this->hasOne(Shift::class, ['shift_id' => 'shift_id']);
    }
}
