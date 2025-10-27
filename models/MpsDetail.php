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
            [['mps_id', 'minggu_ke', 'forecast', 'order_aktual', 'stok', 'rencana_produksi'], 'required'],
            [['mps_id', 'minggu_ke', 'forecast', 'order_aktual', 'stok', 'rencana_produksi'], 'integer'],
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
            'minggu_ke' => 'Minggu Ke',
            'forecast' => 'Forecast',
            'order_aktual' => 'Order Aktual',
            'stok' => 'Stok',
            'rencana_produksi' => 'Rencana Produksi',
        ];
    }
}
