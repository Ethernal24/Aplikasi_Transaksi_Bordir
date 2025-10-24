<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "forecast".
 *
 * @property int $forecast_id
 * @property int $barang_id
 * @property string $metode
 * @property int $mse
 * @property int $hasil_forecast
 * @property int $bulan
 * @property int $tahun
 */
class Forecast extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'forecast';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['barang_id', 'metode', 'hasil_forecast', 'bulan', 'tahun'], 'required'],
            [['barang_id', 'mse', 'hasil_forecast', 'bulan', 'tahun'], 'integer'],
            [['metode'], 'string', 'max' => 255],
            [['mse'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'forecast_id' => 'Forecast ID',
            'barang_id' => 'Barang ID',
            'bulan' => 'Bulan',
            'tahun' => 'Tahun',
            'metode' => 'Metode',
            'mse' => 'Mse',
            'hasil_forecast' => 'Hasil Forecast',
        ];
    }

    public function getBarang()
    {
        return $this->hasOne(Barang::class, ['barang_id' => 'barang_id']);
    }
    public function getMps()
    {
        return $this->hasOne(Barang::class, ['forecast_id' => 'forecast_id']);
    }
}
