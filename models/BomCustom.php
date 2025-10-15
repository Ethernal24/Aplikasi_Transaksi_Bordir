<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bom_custom".
 *
 * @property int $bom_custom_id
 * @property int $permintaan_detail_id
 * @property int $bahan_id
 * @property float $qty_per_unit
 * @property int $unit_id
 * @property int $catatan
 */
class BomCustom extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bom_custom';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['permintaan_detail_id', 'bahan_id', 'qty_per_unit', 'unit_id'], 'required'],
            [['permintaan_detail_id', 'bahan_id', 'unit_id'], 'integer'],
            [['qty_per_unit'], 'number', 'min' => 0],
            [['catatan'], 'safe'],
            [['catatan'], 'string']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'bom_custom_id' => 'Bom Custom ID',
            'permintaan_detail_id' => 'Permintaan Detail ID',
            'bahan_id' => 'Bahan ID',
            'qty_per_unit' => 'Qty Per Unit',
            'unit_id' => 'Unit ID',
            'catatan' => 'Catatan',
        ];
    }

    public function getDetail()
    {
        return $this->hasOne(PermintaanDetail::class, ['permintaan_detail_id' => 'permintaan_detail_id']);
    }
    public function getBahan()
    {
        return $this->hasOne(Barang::class, ['barang_id' => 'bahan_id'])->alias('bahan');
    }
    public function getUnit()
    {
        return $this->hasOne(Unit::class, ['unit_id' => 'unit_id']);
    }
}
