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
            [['mrp_id', 'bahan_id', 'kebutuhan_kotor', 'stock_tersedia', 'kebutuhan_bersih'], 'required'],
            [['mrp_id', 'bahan_id', 'stock_tersedia', 'kebutuhan_bersih'], 'integer'],
            [['kebutuhan_kotor'], 'number'],
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
        ];
    }

    public function getBahan()
    {
        return $this->hasOne(Barang::class, ['barang_id' => 'bahan_id'])->alias('bahan');
    }
    public function getMrp()
    {
        return $this->hasOne(MasterMrp::class, ['mrp_id' => 'mrp_id']);
    }
}
