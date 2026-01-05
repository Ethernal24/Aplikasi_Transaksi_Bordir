<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "production_log_detail".
 *
 * @property int $detail_id
 * @property int $log_id
 * @property int $wo_id
 * @property int|null $vs
 * @property int|null $stitch
 * @property int $kuantitas
 * @property int $bs
 * @property string|null $berat
 */
class ProductionLogDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'production_log_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['log_id', 'activity_id', 'kuantitas', 'bs'], 'required'],
            [['log_id', 'activity_id', 'vs', 'stitch', 'kuantitas', 'bs'], 'integer'],
            [['berat'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'detail_id' => 'Detail ID',
            'log_id' => 'Log ID',
            'activity_id' => 'Activity ID',
            'vs' => 'Vs',
            'stitch' => 'Stitch',
            'kuantitas' => 'Kuantitas',
            'bs' => 'Bs',
            'berat' => 'Berat',
        ];
    }
    public function getLog()
    {
        return $this->hasOne(ProductionLog::class, ['log_id' => 'id_log']);
    }
    public function getActivity()
    {
        return $this->hasOne(ProductionLogActivity::class, ['id_activity' => 'activity_id']);
    }
}
