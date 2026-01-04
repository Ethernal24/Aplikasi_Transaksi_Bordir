<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "workorder_material".
 *
 * @property int $wo_mat_id
 * @property int $wo_id
 * @property int $bahan_id
 * @property int $qty_plan
 * @property int $qty_aktual
 * @property int $status_pengambilan_bahan
 */
class WorkorderMaterial extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'workorder_material';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['wo_id', 'bahan_id', 'qty_plan', 'qty_aktual', 'status_pengambilan_bahan'], 'required'],
            [['wo_id', 'bahan_id', 'qty_plan', 'qty_aktual', 'status_pengambilan_bahan'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'wo_mat_id' => 'Wo Mat ID',
            'wo_id' => 'Wo ID',
            'bahan_id' => 'Bahan ID',
            'qty_plan' => 'Qty Plan',
            'qty_aktual' => 'Qty Aktual',
            'status_pengambilan_bahan' => 'Status Pengambilan Bahan',
        ];
    }
    public function getWo()
    {
        return $this->hasOne(Workorder::class, ['wo_id' => 'wo_id']);
    }
    public function getBahan()
    {
        return $this->hasOne(Barang::class, ['barang_id' => 'bahan_id']);
    }
}
