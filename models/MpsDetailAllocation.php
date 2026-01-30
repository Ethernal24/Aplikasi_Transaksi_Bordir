<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mps_detail_allocation".
 *
 * @property int $mps_detail_allocation_id
 * @property int $mps_detail_id
 * @property int $workcenter_id
 * @property int $qty_mesin_alokasi
 * @property int $qty_karyawan_alokasi
 */
class MpsDetailAllocation extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mps_detail_allocation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mps_detail_id', 'workcenter_id', 'qty_mesin_alokasi', 'qty_karyawan_alokasi'], 'required'],
            [['mps_detail_id', 'workcenter_id', 'qty_mesin_alokasi', 'qty_karyawan_alokasi'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'mps_detail_allocation_id' => 'Mps Detail Allocation ID',
            'mps_detail_id' => 'Mps Detail ID',
            'workcenter_id' => 'Workcenter ID',
            'qty_mesin_alokasi' => 'Qty Mesin Alokasi',
            'qty_karyawan_alokasi' => 'Qty Karyawan Alokasi',
        ];
    }

    public function getMpsDetail()
    {
        return $this->hasOne(MpsDetail::class, ['mps_detail_id' => 'mps_detail_id']);
    }
}
