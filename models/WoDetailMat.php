<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wo_detail_mat".
 *
 * @property int $wo_mat_id
 * @property int $wo_id
 * @property int $bahan_id
 * @property int $qty_dibutuhkan
 * @property int|null $qty_dikeluarkan_aktual
 */
class WoDetailMat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wo_detail_mat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['wo_id', 'bahan_id', 'qty_dibutuhkan'], 'required'],
            [['wo_id', 'bahan_id', 'qty_dibutuhkan', 'qty_dikeluarkan_aktual'], 'integer'],
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
            'qty_dibutuhkan' => 'Qty Dibutuhkan',
            'qty_dikeluarkan_aktual' => 'Qty Dikeluarkan Aktual',
        ];
    }
}
