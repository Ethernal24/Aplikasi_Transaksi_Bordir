<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bom".
 *
 * @property int $bom_id
 * @property int $produk_id
 * @property int $bahan_id
 * @property int $qty_per_unit
 * @property int $unit_id
 */
class Bom extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bom';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // 1. Definisikan SAFE paling atas khusus untuk scenario ini
            [['produk_id'], 'safe', 'on' => 'update'],

            // 2. Rules Global (Kecuali produk_id)
            [['bahan_id', 'qty_per_unit', 'unit_id'], 'required'],
            [['bahan_id', 'unit_id'], 'integer'],
            [['qty_per_unit'], 'number'],

            // 3. Rules khusus produk_id (HANYA jika BUKAN scenario update)
            // Gunakan list scenario yang pasti (default) daripada except
            [['produk_id'], 'required', 'on' => 'default'],
            [['produk_id'], 'integer', 'on' => 'default'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'bom_id' => 'Bom ID',
            'produk_id' => 'Produk ID',
            'bahan_id' => 'Bahan ID',
            'qty_per_unit' => 'Qty Per Unit',
            'unit_id' => 'Unit ID',
        ];
    }

    public function getProduk()
    {
        return $this->hasOne(Barang::class, ['barang_id' => 'produk_id'])->alias('produk');
    }
    public function getBahan()
    {
        return $this->hasOne(Barang::class, ['barang_id' => 'bahan_id'])->alias('bahan');
    }
    public function getUnit()
    {
        return $this->hasOne(Unit::class, ['unit_id' => 'unit_id'])->alias('satuan');
    }
}
