<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "permintaan_detail".
 *
 * @property int $permintaan_detail_id
 * @property int $permintaan_id
 * @property int $produk_custom_pelanggan_id
 * @property int $jumlah
 */
class PermintaanDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'permintaan_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['produk_custom_pelanggan_id', 'jumlah'], 'required'],
            [['permintaan_id', 'produk_custom_pelanggan_id', 'jumlah'], 'integer'],
            [['permintaan_id', 'deskripsi'], 'safe'],
            [['deskripsi'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'permintaan_detail_id' => 'Permintaan Detail ID',
            'permintaan_id' => 'Permintaan ID',
            'produk_custom_pelanggan_id' => 'Produk Custom Pelanggan ID',
            'jumlah' => 'Jumlah',
            'deskripsi' => 'Deskripsi',
        ];
    }
    public function getPermintaan()
    {
        return $this->hasOne(PermintaanPelanggan::class, ['permintaan_id' => 'permintaan_id']);
    }
    public function getProdukCustom()
    {
        return $this->hasOne(ProdukCustomPelanggan::class, ['produk_custom_pelanggan_id' => 'produk_custom_pelanggan_id']);
    }

    public function getBomCustom()
    {
        return $this->hasMany(BomCustom::class, ['permintaan_detail_id' => 'permintaan_detail_id']);
    }
}
