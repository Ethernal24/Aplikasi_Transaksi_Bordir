<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mesin".
 *
 * @property int $mesin_id
 * @property string $nama
 * @property string $deskripsi
 *
 * @property LaporanProduksi[] $laporanProduksis
 * @property Shift[] $shifts
 */
class Mesin extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mesin';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_mesin', 'workcenter_id', 'kode_mesin', 'status_mesin', 'max_waktu_operasi_menit', 'tipe_mesin'], 'required'],
            [['deskripsi', 'kode_mesin', 'tipe_mesin'], 'string'],
            [['deskripsi'], 'safe'],
            [['status_mesin', 'workcenter_id', 'max_waktu_operasi_menit'], 'integer'],
            [['nama_mesin'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'mesin_id' => 'Mesin ID',
            'workcenter_id' => 'workcenter ID',
            'kode_mesin' => 'Kode Mesin',
            'nama_mesin' => 'Nama Mesin',
            'tipe_mesin' => 'Tipe Mesin',
            'deskripsi' => 'Deskripsi',
            'status_mesin' => 'Status Mesin',
            'max_waktu_operasi_menit' => 'Maksimal Waktu Operasi (menit)',
        ];
    }

    /**
     * Gets query for [[LaporanProduksis]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLaporanProduksis()
    {
        return $this->hasMany(LaporanProduksi::class, ['mesin_id' => 'mesin_id']);
    }

    /**
     * Gets query for [[Shifts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getShifts()
    {
        return $this->hasMany(Shift::class, ['shift_id' => 'shift_id'])->viaTable('laporanproduksi', ['mesin_id' => 'mesin_id']);
    }

    public function getLaporan()
    {
        return $this->hasMany(LaporanProduksi::class, ['nama_mesin' => 'nama_mesin']);
    }
    public function getWorkCenter()
    {
        return $this->hasOne(Workcenter::class, ['workcenter_id' => 'workcenter_id']);
    }
    public function getLabel()
    {
        $status = [
            '0' => [
                'label' => 'Available',
                'class' => 'badge bg-success'
            ],
            '1' => [
                'label' => 'On-Work',
                'class' => 'badge bg-info'
            ],
            '2' => [
                'label' => 'Maintenance',
                'class' => 'badge bg-warning'
            ],
        ];
        return isset($status[$this->status_mesin]) ? $status[$this->status_mesin] : ['label' => 'unknown', 'class' => 'badge bg-secondary'];
    }
}
