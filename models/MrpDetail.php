<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mrp_detail".
 *
 * @property int $mrp_detail_id
 * @property int $mrp_id
 * @property int $barang_id
 * @property int $minggu_ke
 * @property int $kebutuhan_kotor
 * @property int $stock_tersedia
 * @property int $kebutuhan_bersih
 * @property int $leadtime
 * @property int $planned_order_release
 * @property int $planned_order_receipt
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
            [['mrp_id', 'barang_id', 'minggu_ke', 'kebutuhan_kotor', 'stock_tersedia', 'kebutuhan_bersih', 'leadtime', 'planned_order_release', 'planned_order_receipt'], 'required'],
            [['mrp_id', 'barang_id', 'stock_tersedia', 'kebutuhan_bersih', 'leadtime', 'minggu_ke'], 'integer'],
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
            'barang_id' => 'Bahan ID',
            'minggu_ke' => 'Minggu Ke',
            'kebutuhan_kotor' => 'Kebutuhan Kotor',
            'stock_tersedia' => 'Stock Tersedia',
            'kebutuhan_bersih' => 'Kebutuhan Bersih',
            'leadtime' => 'Leadtime',
            'planned_order_release' => 'Planned Order Release',
            'planned_order_receipt' => 'Planned Order Receipt',
        ];
    }

    public function getBarang()
    {
        return $this->hasOne(Barang::class, ['barang_id' => 'barang_id']);
    }
    public function getMrp()
    {
        return $this->hasOne(MasterMrp::class, ['mrp_id' => 'mrp_id']);
    }
}
