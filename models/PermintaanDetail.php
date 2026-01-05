<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "permintaan_detail".
 *
 * @property int $permintaan_detail_id
 * @property int $permintaan_id
 * @property int $produk_id
 * @property int $jumlah
 * @property string $deskripsi
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
            [['produk_id', 'jumlah'], 'required'],
            [['permintaan_id', 'produk_id', 'jumlah'], 'integer'],
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
            'produk_id' => 'Produk ID',
            'jumlah' => 'Jumlah',
            'deskripsi' => 'Deskripsi',
        ];
    }
    public function getPermintaan()
    {
        return $this->hasOne(PermintaanPelanggan::class, ['permintaan_id' => 'permintaan_id']);
    }
    public function getProduk()
    {
        return $this->hasOne(Barang::class, ['barang_id' => 'produk_id']);
    }

    public function getBomCustom()
    {
        return $this->hasMany(BomCustom::class, ['permintaan_detail_id' => 'permintaan_detail_id']);
    }
    public function getWorkOrder()
    {
        return $this->hasOne(Workorder::class, ['permintaan_detail_id' => 'permintaan_detail_id']);
    }
}
