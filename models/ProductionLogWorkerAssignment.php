<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "production_log_worker_assignment".
 *
 * @property int $id_assignment
 * @property string $tanggal_assignment
 * @property int $id_tk
 * @property int $id_workcenter
 * @property int $id_shift
 * @property int|null $id_wo
 */
class ProductionLogWorkerAssignment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'production_log_worker_assignment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tanggal_assignment', 'id_tk', 'id_workcenter', 'id_shift', 'id_mesin'], 'required'],
            [['tanggal_assignment', 'id_wo'], 'safe'],
            [['id_tk', 'id_workcenter', 'id_shift', 'id_wo'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_assignment' => 'Id Assignment',
            'tanggal_assignment' => 'Tanggal Assignment',
            'id_tk' => 'Id Tk',
            'id_workcenter' => 'Id Workcenter',
            'id_shift' => 'Id Shift',
            'id_wo' => 'Id Wo',
            'id_mesin' => 'ID Mesin',
        ];
    }
    public function getTk()
    {
        return $this->hasOne(TenagaKerja::class, ['tk_id' => 'id_tk']);
    }
    public function getWorkCenter()
    {
        return $this->hasOne(Workcenter::class, ['workcenter_id' => 'id_workcenter']);
    }
    public function getShift()
    {
        return $this->hasOne(Shift::class, ['shift_id' => 'id_shift']);
    }
    public function getWorkOrder()
    {
        return $this->hasOne(Workorder::class, ['id_wo' => 'id_wo']);
    }
    public function getMesin()
    {
        return $this->hasOne(Mesin::class, ['id_mesin' => 'mesin_id']);
    }
}
