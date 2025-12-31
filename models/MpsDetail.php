<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mps_detail".
 *
 * @property int $mps_detail_id
 * @property int $mps_id
 * @property int $minggu_ke
 * @property int $forecast
 * @property int $order_aktual
 * @property int $stok
 * @property int $rencana_produksi
 */
class MpsDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mps_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['permintaan_id', 'produk_id', 'qty_plan'], 'required'],
            [['mps_id', 'permintaan_id', 'produk_id', 'qty_plan'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'mps_detail_id' => 'Mps Detail ID',
            'mps_id' => 'Mps ID',
            'permintaan_id' => 'Permintaan ID',
            'produk_id' => 'produk ID',
            'qty_plan' => 'Qty Plan',
        ];
    }

    public function getMps()
    {
        return $this->hasOne(mps::class, ['mps_id' => 'mps_id']);
    }
    public function getPermintaan()
    {
        return $this->hasOne(PermintaanPelanggan::class, ['permintaan_id' => 'permintaan_id']);
    }
    public function getProduk()
    {
        return $this->hasOne(Barang::class, ['barang_id' => 'produk_id']);
    }
}
