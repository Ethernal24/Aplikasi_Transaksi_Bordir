<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "permintaan_pelanggan".
 *
 * @property int $permintaan_id
 * @property int $pelanggan_id
 * @property string $tanggal_permintaan
 * @property PermintaanDetail[] $details
 */
class PermintaanPelanggan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'permintaan_pelanggan';
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
}
