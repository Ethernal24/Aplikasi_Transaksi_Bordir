<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "jadwal_simulasi".
 *
 * @property int $simulasi_id
 * @property int $produk_id
 * @property int $quantity
 * @property string $tanggal_mulai
 * @property string $dateline
 * @property string $estimasi_selesai
 */
class JadwalSimulasi extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jadwal_simulasi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['produk_id', 'quantity', 'tanggal_mulai', 'dateline', 'estimasi_selesai'], 'required'],
            [['produk_id', 'quantity'], 'integer'],
            [['tanggal_mulai', 'dateline', 'estimasi_selesai', 'pelanggan_id'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'simulasi_id' => 'Simulasi ID',
            'pelanggan_id' => 'Pelanggan ID',
            'produk_id' => 'Produk ID',
            'quantity' => 'Quantity',
            'tanggal_mulai' => 'Tanggal Mulai',
            'dateline' => 'Dateline',
            'estimasi_selesai' => 'Estimasi Selesai',
        ];
    }

    public function getProduk()
    {
        return $this->hasOne(Barang::class, ['barang_id' => 'produk_id']);
    }

    public static function getRoutingByProduct($produk_id)
    {
        // Sesuaikan dengan nama tabel/model routing Anda
        $routing = \app\models\MasterRouting::find()
            ->where(['produk_id' => $produk_id])
            ->one();
        return $routing ? $routing->routing_id : null;
    }
}
