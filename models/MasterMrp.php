<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "master_mrp".
 *
 * @property int $mrp_id
 * @property int $mps_id
 * @property int $status
 * @property string $kode_mrp
 * @property MrpDetail[] $MrpDetails
 */
class MasterMrp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_mrp';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['dibuat_pada', 'diupdate_pada'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['diupdate_pada'],
                ],
                'value' => new Expression('NOW()'), // or date('Y-m-d H:i:s')
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mps_id', 'status'], 'required'],
            [['mps_id', 'status'], 'integer'],
            [['kode_mrp'], 'string']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'mrp_id' => 'Mrp ID',
            'mps_id' => 'Mps ID',
            'kode_mrp' => 'Kode MRP',
            'status' => 'Status',
        ];
    }

    public function getMps()
    {
        return $this->hasOne(Mps::class, ['mps_id' => 'mps_id']);
    }

    public function getLabel()
    {
        $status = [
            '0' => [
                'label' => 'Draft',
                'class' => 'badge bg-info'
            ],
            '1' => [
                'label' => 'Approved',
                'class' => 'badge bg-success'
            ],
        ];
        return isset($status[$this->status]) ? $status[$this->status] : ['label' => 'unknown', 'class' => 'badge bg-secondary'];
    }

    public function getMrpDetails()
    {
        return $this->hasMany(MrpDetail::class, ['mrp_id' => 'mrp_id']);
    }
}
