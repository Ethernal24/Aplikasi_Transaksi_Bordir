<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "production_log".
 *
 * @property int $id_log
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
            [['kode_log', 'id_wo', 'id_workcenter', 'id_shift', 'tanggal', 'status'], 'required'],
            [['id_wo', 'id_workcenter', 'id_shift', 'status'], 'integer'],
            [['kode_log'], 'string'],
            [['tanggal'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kode_log' => 'Kode Log',
            'id_wo' => 'ID WO',
            'id_workcenter' => 'ID Workcenter',
            'id_shift' => 'ID Shift',
            'tanggal' => 'Tanggal',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */

    public function getShift()
    {
        return $this->hasOne(Shift::class, ['shift_id' => 'id_shift']);
    }
    public function getWo()
    {
        return $this->hasOne(Workorder::class, ['id_wo' => 'id_wo']);
    }
    public function getWorkcenter()
    {
        return $this->hasOne(Workcenter::class, ['workcenter_id' => 'id_workcenter']);
    }

    public function getLabelStatus()
    {
        $status = [
            0      => ['label' => 'Sedang Jalan', 'class' => 'badge bg-primary'],
            1    => ['label' => 'Tertunda', 'class' => 'badge bg-warning'],

            2 => ['label' => 'Selesai', 'class' => 'badge bg-success'],
        ];

        return $status[$this->status] ?? ['label' => $this->status, 'class' => 'badge badge-secondary'];
    }
    public function getActivity()
    {
        return $this->hasMany(ProductionLogActivity::class, ['id_log' => 'id_log']);
    }
}
