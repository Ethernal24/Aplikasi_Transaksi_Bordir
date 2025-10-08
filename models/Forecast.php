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
            [['barang_id', 'metode', 'mse', 'hasil_forecast'], 'required'],
            [['barang_id', 'mse', 'hasil_forecast'], 'integer'],
            [['metode'], 'string', 'max' => 255],
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
            'metode' => 'Metode',
            'mse' => 'Mse',
            'hasil_forecast' => 'Hasil Forecast',
        ];
    }
}
