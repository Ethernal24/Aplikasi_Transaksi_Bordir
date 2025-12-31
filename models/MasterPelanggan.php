<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "master_pelanggan".
 *
 * @property int $pelanggan_id
 * @property string $nama_pelanggan
 * @property string $instansi
 * @property string|null $pesenan_terakhir
 * @property string|null $kode
 */
class MasterPelanggan extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_pelanggan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pesenan_terakhir'], 'default', 'value' => null],
            [['nama_pelanggan', 'instansi', 'no_telp'], 'required'],
            [['pesenan_terakhir', 'kode'], 'safe'],
            [['nama_pelanggan', 'no_telp', 'instansi', 'kode'], 'string', 'max' => 255],
            ['no_telp', 'match', 'pattern' => '/^[0-9]+$/', 'message' => 'Nomor telepon hanya boleh berisi angka.'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pelanggan_id' => 'Pelanggan ID',
            'nama_pelanggan' => 'Nama Pelanggan',
            'instansi' => 'Instansi',
            'kode' => 'Kode',
            'pesenan_terakhir' => 'Pesanan Terakhir',
        ];
    }

    public function getPermintaanPelanggan()
    {
        return $this->hasMany(PermintaanPelanggan::class, ['pelanggan_id' => 'pelanggan_id']);
    }
    public function getProdukCustomPelanggan()
    {
        return $this->hasMany(ProdukCustomPelanggan::class, ['pelanggan_id' => 'pelanggan_id']);
    }
}
