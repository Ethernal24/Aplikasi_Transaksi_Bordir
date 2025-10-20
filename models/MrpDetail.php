<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mrp_detail".
 *
 * @property int $mrp_detail_id
 * @property int $mrp_id
 * @property int $bahan_id
 * @property float $kebutuhan_kotor
 * @property int $stock_tersedia
 * @property int $kebutuhan_bersih
 * @property int $leadtime
 * @property string $planned_order_release
 * @property string $planned_order_receipt
 */
class MrpDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mrp_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mrp_id', 'bahan_id', 'kebutuhan_kotor', 'stock_tersedia', 'kebutuhan_bersih', 'leadtime', 'planned_order_release', 'planned_order_receipt'], 'required'],
            [['mrp_id', 'bahan_id', 'stock_tersedia', 'kebutuhan_bersih', 'leadtime'], 'integer'],
            [['kebutuhan_kotor'], 'number'],
            [['planned_order_release', 'planned_order_receipt'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'mrp_detail_id' => 'Mrp Detail ID',
            'mrp_id' => 'Mrp ID',
            'bahan_id' => 'Bahan ID',
            'kebutuhan_kotor' => 'Kebutuhan Kotor',
            'stock_tersedia' => 'Stock Tersedia',
            'kebutuhan_bersih' => 'Kebutuhan Bersih',
            'leadtime' => 'Leadtime',
            'planned_order_release' => 'Planned Order Release',
            'planned_order_receipt' => 'Planned Order Receipt',
        ];
    }
}
