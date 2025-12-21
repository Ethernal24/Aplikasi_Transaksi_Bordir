<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kehadiran".
 *
 * @property int $kehadiran_id
 * @property string $tanggal
 * @property int $tk_id
 * @property int $shift_id
 * @property int $status_kehadiran
 * @property string $jam_masuk_real
 * @property string $jam_pulang_real
 */
class Kehadiran extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kehadiran';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                ['tk_id', 'tanggal'],
                'unique',
                'targetAttribute' => ['tk_id', 'tanggal'],
                'message' => 'Anda sudah melakukan input kehadiran untuk tanggal ini.'
            ],
            [['tanggal', 'tk_id', 'shift_id', 'status_kehadiran'], 'required'],
            [['tanggal', 'jam_masuk_real', 'jam_pulang_real'], 'safe'],
            [['tk_id', 'shift_id', 'status_kehadiran'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kehadiran_id' => 'Kehadiran ID',
            'tanggal' => 'Tanggal',
            'tk_id' => 'Tk ID',
            'shift_id' => 'Shift ID',
            'status_kehadiran' => 'Status Kehadiran',
            'jam_masuk_real' => 'Jam Masuk Real',
            'jam_pulang_real' => 'Jam Pulang Real',
        ];
    }

    public function getTenagaKerja()
    {
        return $this->hasOne(TenagaKerja::class, ['tk_id' => 'tk_id']);
    }
    public function getShift()
    {
        return $this->hasOne(Shift::class, ['shift_id' => 'shift_id']);
    }
}
