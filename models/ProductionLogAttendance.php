<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "production_log_attendance".
 *
 * @property int $attendance_id
 * @property int $tk_id
 * @property int $log_id
 * @property string $mulai_kerja
 * @property string $selesai_kerja
 * @property float $waktu_kerja
 * @property string $mulai_istirahat
 * @property string $selesai_istirahat
 *
 * @property User $tk
 */
class ProductionLogAttendance extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'production_log_attendance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tk_id', 'log_id', 'mulai_kerja', 'selesai_kerja', 'waktu_kerja', 'mulai_istirahat', 'selesai_istirahat'], 'required'],
            [['tk_id', 'log_id'], 'integer'],
            [['mulai_kerja', 'selesai_kerja', 'mulai_istirahat', 'selesai_istirahat'], 'safe'],
            [['waktu_kerja'], 'number'],
            [['tk_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['tk_id' => 'user_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'attendance_id' => 'Attendance ID',
            'tk_id' => 'Tk ID',
            'log_id' => 'Log ID',
            'mulai_kerja' => 'Mulai Kerja',
            'selesai_kerja' => 'Selesai Kerja',
            'waktu_kerja' => 'Waktu Kerja',
            'mulai_istirahat' => 'Mulai Istirahat',
            'selesai_istirahat' => 'Selesai Istirahat',
        ];
    }

    /**
     * Gets query for [[Tk]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTk()
    {
        return $this->hasOne(User::class, ['user_id' => 'tk_id']);
    }
}
