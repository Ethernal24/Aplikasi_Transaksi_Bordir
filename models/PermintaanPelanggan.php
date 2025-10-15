<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "permintaan_pelanggan".
 *
 * @property int $permintaan_id
 * @property int $nama_pelanggan
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
            [['nama_pelanggan', 'kode_permintaan', 'tenggat_waktu', 'status_pesanan'], 'required'],
            [['nama_pelanggan', 'kode_permintaan'], 'string'],
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
            'nama_pelanggan' => 'Nama Pelanggan',
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
}
