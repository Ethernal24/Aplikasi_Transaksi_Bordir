<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tenaga_kerja".
 *
 * @property int $tk_id
 * @property string $nama
 * @property string $jabatan
 * @property string $kemampuan
 * @property int $status_kerja 0 = avail
 1 = off
 * @property int $shift_id
 * @property string $dibuat_pada
 * @property string $diupdate_pada
 */
class TenagaKerja extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tenaga_kerja';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama', 'jabatan', 'kemampuan', 'status_kerja'], 'required'],
            [['status_kerja'], 'integer'],
            [['dibuat_pada', 'diupdate_pada'], 'safe'],
            [['nama', 'jabatan', 'kemampuan'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tk_id' => 'Tk ID',
            'nama' => 'Nama',
            'jabatan' => 'Jabatan',
            'kemampuan' => 'Kemampuan',
            'status_kerja' => 'Status Kerja',
            'dibuat_pada' => 'Dibuat Pada',
            'diupdate_pada' => 'Diupdate Pada',
        ];
    }

    public function getShift()
    {
        return $this->hasOne(Shift::class, ['shift_id' => 'shift_id']);
    }

    public function getWorkCenter()
    {
        return $this->hasOne(Workcenter::class, ['workcenter_id' => 'workcenter_id']);
    }
}
