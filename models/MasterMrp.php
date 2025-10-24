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
                'label' => 'Pending',
                'class' => 'badge bg-warning'
            ],
            '1' => [
                'label' => 'In progress',
                'class' => 'badge bg-info'
            ],
            '2' => [
                'label' => 'Done',
                'class' => 'badge bg-success'
            ],
        ];
        return isset($status[$this->status]) ? $status[$this->status] : ['label' => 'unknown', 'class' => 'badge bg-secondary'];
    }
}
