<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "riwayat_permintaan".
 *
 * @property int $riwayat_id
 * @property int $barang_id
 * @property string $bulan
 * @property int $tahun
 * @property int $jumlah_permintaan
 */
class RiwayatPermintaan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'riwayat_permintaan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['barang_id', 'bulan', 'tahun', 'jumlah_permintaan'], 'required'],
            [['barang_id', 'tahun', 'jumlah_permintaan'], 'integer'],
            [['bulan'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'riwayat_id' => 'Riwayat ID',
            'barang_id' => 'Barang ID',
            'bulan' => 'Bulan',
            'tahun' => 'Tahun',
            'jumlah_permintaan' => 'Jumlah Permintaan',
        ];
    }
    public function getBarang()
    {
        return $this->hasOne(Barang::class, ['barang_id' => 'barang_id']);
    }
}
