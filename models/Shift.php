<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "shift".
 *
 * @property int $shift_id
 * @property int $user_id
 * @property string $tanggal
 * @property string $shift
 * @property float $waktu_kerja
 * @property string $nama_operator
 * @property string $mulai_istirahat
 * @property string $selesai_istirahat
 * @property string $kendala
 * @property int $ganti_benang
 * @property int $ganti_kain
 *
 * @property LaporanProduksi[] $laporanProduksis
 * @property Mesin[] $mesins
 * @property User $user
 */
class Shift extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public static function tableName()
    {
        return 'shift';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_shift', 'jam_mulai', 'jam_selesai', 'jam_efektif'], 'required'],
            [['jam_mulai', 'jam_selesai'], 'date', 'type' => 'time', 'format' => 'php:H:i'],
            [['jam_efektif'], 'number'],
        ];
    }

    /**s
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'shift_id' => 'Shift ID',
            'nama_shift' => 'Nama Shift',
            'jam_mulai' => 'Jam Mulai',
            'jam_selesai' => 'Jam Selesai',
            'jam_efektif' => 'Jam Efektif',

        ];
    }
    public function getMps()
    {
        return $this->hasOne(Mps::class, ['shift_id' => 'shift_id']);
    }
}
