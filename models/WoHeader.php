<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wo_header".
 *
 * @property int $wo_id
 * @property string $kode_wo
 * @property int $produk_id
 * @property string $tanggal_dibuat
 * @property string $tanggal_selesai
 * @property int $status_wo
 */
class WoHeader extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wo_header';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_wo', 'produk_id', 'tanggal_dibuat', 'tanggal_selesai', 'status_wo'], 'required'],
            [['produk_id', 'status_wo'], 'integer'],
            [['tanggal_dibuat', 'tanggal_selesai', 'prioritas_wo'], 'safe'],
            [['kode_wo'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'wo_id' => 'Wo ID',
            'kode_wo' => 'Kode Wo',
            'produk_id' => 'Produk ID',
            'tanggal_dibuat' => 'Tanggal Dibuat',
            'tanggal_selesai' => 'Tanggal Selesai',
            'status_wo' => 'Status Wo',
            'prioritas_wo' => 'Prioritas Wo',
        ];
    }

    public function getProduk()
    {
        return $this->hasOne(Barang::class, ['barang_id' => 'produk_id']);
    }

    public function getDetailOpr()
    {
        return $this->hasMany(WoDetailOpr::class, ['wo_id' => 'wo_id']);
    }

    public function getDetailMat()
    {
        return $this->hasMany(WoDetailMat::class, ['wo_id' => 'wo_id']);
    }
}
