<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "permintaan_pelanggan".
 *
 * @property int $permintaan_id
 * @property int $pelanggan_id
 * @property string $tanggal_permintaan
 * @property string $tenggat_waktu
 * @property int $status_pesanan
 * @property PermintaanDetail[] $details
 */
class PermintaanPelanggan extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'permintaan_pelanggan';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'dibuat_pada',
                'updatedAtAttribute' => 'diupdate_pada',
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
            [['pelanggan_id', 'kode_permintaan', 'tenggat_waktu', 'status_pesanan'], 'required'],
            [['kode_permintaan'], 'string'],
            [['pelanggan_id'], 'integer'],
            [['tanggal_permintaan', 'dibuat_pada', 'diupdate_pada'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'permintaan_id' => 'Permintaan ID',
            'pelanggan_id' => 'pelanggan ID',
            'tanggal_permintaan' => 'Tanggal Permintaan',
            'kode_permintaan' => 'Kode Permintaan',
            'tenggat_waktu' => 'Tenggat Waktu',
            'status_pesanan' => 'Status Pesanan',
        ];
    }

    public function getDetails()
    {
        return $this->hasMany(PermintaanDetail::class, ['permintaan_id' => 'permintaan_id']);
    }
    public function getPelanggan()
    {
        return $this->hasOne(MasterPelanggan::class, ['pelanggan_id' => 'pelanggan_id']);
    }

    public function getLabel()
    {
        $status = [
            '0' => ['label' => 'Antrian', 'class' => 'badge bg-info'],
            '1' => ['label' => 'Proses', 'class' => 'badge bg-warning'],
            '2' => ['label' => 'Selesai', 'class' => 'badge bg-success'],
        ];

        return isset($status[$this->status_pesanan]) ? $status[$this->status_pesanan] : ['label' => 'Unknown', 'class' => 'badge bg-secondary'];
    }

    public function getMpsDetail()
    {
        return $this->hasMany(MpsDetail::class, ['permintaan_id' => 'permintaan_id']);
    }

    public function getWorkOrder()
    {
        return $this->hasMany(Workorder::class, ['permintaan_id' => 'permintaan_id']);
    }
}
