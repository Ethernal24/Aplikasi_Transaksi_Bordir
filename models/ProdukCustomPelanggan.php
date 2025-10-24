<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "produk_custom_pelanggan".
 *
 * @property int $produk_custom_pelanggan_id
 * @property int $pelanggan_id
 * @property string $kode_barang
 * @property string $nama_barang_custom
 * @property string|null $dibuat_pada
 * @property string|null $diupdate_pada
 */
class ProdukCustomPelanggan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'produk_custom_pelanggan';
    }
    public static function primaryKey()
    {
        return ['produk_custom_pelanggan_id'];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_barang', 'nama_barang_custom'], 'required'],
            [['pelanggan_id'], 'integer'],
            [['pelanggan_id', 'dibuat_pada', 'diupdate_pada'], 'safe'],
            [['kode_barang', 'nama_barang_custom'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'produk_custom_pelanggan_id' => 'Produk Custom Pelanggan ID',
            'pelanggan_id' => 'Pelanggan ID',
            'kode_barang' => 'Kode Barang',
            'nama_barang_custom' => 'Nama Barang Custom',
            'dibuat_pada' => 'Dibuat Pada',
            'diupdate_pada' => 'Diupdate Pada',
        ];
    }

    public function getPelanggan()
    {
        return $this->hasOne(MasterPelanggan::class, ['pelanggan_id' => 'pelanggan_id']);
    }

    public function getbomCustom()
    {
        return $this->hasMany(BomCustom::class, ['produk_custom_pelanggan_id' => 'produk_custom_pelanggan_id']);
    }
}
