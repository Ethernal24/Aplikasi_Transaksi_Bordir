<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wo_detail_opr".
 *
 * @property int $wo_opr_id
 * @property int $wo_id
 * @property int $urutan_operasi
 * @property int $mesin_id
 * @property int $shift_id
 * @property string|null $tanggal_mulai_aktual
 * @property int|null $qty_selesai_aktual
 * @property int $waktu_standar_menit
 * @property string|null $catatan_serah_terima
 */
class WoDetailOpr extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wo_detail_opr';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['wo_id', 'urutan_operasi', 'mesin_id', 'shift_id', 'waktu_standar_menit'], 'required'],
            [['wo_id', 'urutan_operasi', 'mesin_id', 'shift_id', 'qty_selesai_aktual', 'waktu_standar_menit'], 'integer'],
            [['tanggal_mulai_aktual'], 'safe'],
            [['catatan_serah_terima'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'wo_opr_id' => 'Wo Opr ID',
            'wo_id' => 'Wo ID',
            'urutan_operasi' => 'Urutan Operasi',
            'mesin_id' => 'Mesin ID',
            'shift_id' => 'Shift ID',
            'tanggal_mulai_aktual' => 'Tanggal Mulai Aktual',
            'qty_selesai_aktual' => 'Qty Selesai Aktual',
            'waktu_standar_menit' => 'Waktu Standar Menit',
            'catatan_serah_terima' => 'Catatan Serah Terima',
        ];
    }
}
