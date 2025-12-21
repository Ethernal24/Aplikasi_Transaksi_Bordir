<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "production_log".
 *
 * @property int $production_log_id
 * @property string $tanggal
 * @property int $user_id
 * @property int $shift_id
 * @property float $waktu_kerja
 * @property string $mulai_istirahat
 * @property string $selesai_istirahat
 * @property string $kendala
 * @property int|null $ganti_benang
 * @property int|null $ganti_kain
 *
 * @property User $user
 */
class ProductionLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'production_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tanggal', 'tk_id', 'shift_id', 'waktu_kerja', 'mulai_istirahat', 'selesai_istirahat', 'mesin_id'], 'required'],
            [['tanggal', 'mulai_kerja', 'selesai_kerja'], 'safe'],
            [['tk_id', 'shift_id', 'mesin_id'], 'integer'],
            [['waktu_kerja'], 'number'],
            [['tk_id'], 'exist', 'skipOnError' => true, 'targetClass' => TenagaKerja::class, 'targetAttribute' => ['tk_id' => 'tk_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'production_log_id' => 'Production Log ID',
            'tanggal' => 'Tanggal',
            'mesin_id' => 'mesin_id',
            'tk_id' => 'Tenaga Kerja ID',
            'shift_id' => 'Shift ID',
            'mulai_kerja' => 'Mulai Kerja',
            'selesai_kerja' => 'Selesai Kerja',
            'waktu_kerja' => 'Waktu Kerja',
            'mulai_istirahat' => 'Mulai Istirahat',
            'selesai_istirahat' => 'Selesai Istirahat',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTenagaKerja()
    {
        return $this->hasOne(TenagaKerja::class, ['tk_id' => 'tk_id']);
    }
    public function getShift()
    {
        return $this->hasOne(Shift::class, ['shift_id' => 'shift_id']);
    }
    public function getMesin()
    {
        return $this->hasOne(Mesin::class, ['mesin_id' => 'mesin_id']);
    }
    public function getDetail()
    {
        return $this->hasOne(ProductionLogDetail::class, ['production_log_id' => 'log_id']);
    }
    public function getActivity()
    {
        return $this->hasOne(ProductionLogActivity::class, ['production_log_id' => 'log_id']);
    }
}
