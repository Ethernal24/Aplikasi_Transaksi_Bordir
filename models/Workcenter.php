<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "workcenter".
 *
 * @property int $workcenter_id
 * @property string $kode_workcenter
 * @property string $nama_workcenter
 * @property string $tipe_kapasitas mesin / orang
 * @property int $tk_id penanggung jawab / pekerja
 * @property string $keterangann
 */
class Workcenter extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'workcenter';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_workcenter', 'nama_workcenter', 'tipe_kapasitas', 'keterangann'], 'required'],
            [['tipe_kapasitas'], 'integer'],
            [['kode_workcenter', 'nama_workcenter', 'keterangann'], 'string', 'max' => 255],
            [['kode_workcenter'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'workcenter_id' => 'Workcenter ID',
            'kode_workcenter' => 'Kode Workcenter',
            'nama_workcenter' => 'Nama Workcenter',
            'tipe_kapasitas' => 'Tipe Kapasitas',
            'keterangann' => 'Keterangann',
        ];
    }

    public function getTenagaKerja()
    {
        return $this->hasOne(TenagaKerja::class, ['tk_id' => 'tk_id']);
    }

    public function getRoutingDetails()
    {
        return $this->hasMany(RoutingDetail::class, ['workcenter_id' => 'workcenter_id']);
    }
}
