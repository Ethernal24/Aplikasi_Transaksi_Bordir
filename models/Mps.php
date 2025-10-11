<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mps".
 *
 * @property int $mps_id
 * @property int $forecast_id
 * @property int $stock_awal
 * @property int $rencana_produksi
 */
class Mps extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mps';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['forecast_id', 'stock_awal'], 'required'],
            [['forecast_id', 'stock_awal', 'rencana_produksi'], 'integer'],
            [['rencana_produksi'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'mps_id' => 'Mps ID',
            'forecast_id' => 'Forecast ID',
            'stock_awal' => 'Stock Awal',
            'rencana_produksi' => 'Rencana Produksi',
        ];
    }

    public function getForecast()
    {
        return $this->hasOne(Forecast::class, ['forecast_id' => 'forecast_id']);
    }
}
