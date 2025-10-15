<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "permintaan_detail".
 *
 * @property int $permintaan_detail_id
 * @property int $permintaan_id
 * @property int $barang_id
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
            [['barang_id', 'jumlah', 'deskripsi'], 'required'],
            [['permintaan_id', 'barang_id', 'jumlah'], 'integer'],
            [['permintaan_id'], 'safe'],
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
            'barang_id' => 'Barang ID',
            'jumlah' => 'Jumlah',
            'deskripsi' => 'Deskripsi',
        ];
    }
    public function getPermintaan()
    {
        return $this->hasOne(PermintaanPelanggan::class, ['permintaan_id' => 'permintaan_id']);
    }
    public function getBarang()
    {
        return $this->hasOne(Barang::class, ['barang_id' => 'barang_id']);
    }

    public function getBomCustom()
    {
        return $this->hasMany(BomCustom::class, ['permintaan_detail_id' => 'permintaan_detail_id']);
    }
}
