<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "production_log_downtime".
 *
 * @property int $downtime_id
 * @property int $log_id
 * @property int|null $ganti_benang
 * @property int|null $ganti_kain
 * @property string|null $kendala
 * @property int $durasi_menit
 */
class ProductionLogDowntime extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'production_log_downtime';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['log_id', 'durasi_menit'], 'required'],
            [['log_id', 'ganti_benang', 'ganti_kain', 'durasi_menit'], 'integer'],
            [['kendala'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'downtime_id' => 'Downtime ID',
            'log_id' => 'Log ID',
            'ganti_benang' => 'Ganti Benang',
            'ganti_kain' => 'Ganti Kain',
            'kendala' => 'Kendala',
            'durasi_menit' => 'Durasi Menit',
        ];
    }
}
