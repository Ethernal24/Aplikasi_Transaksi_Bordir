<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "routing_detail".
 *
 * @property int $routing_detail_id
 * @property int $routing_id
 * @property int $urutan
 * @property string $nama_proses
 * @property int $mesin_id
 * @property int $tenaga_kerja_id
 * @property string $waktu_setup_menit
 * @property string $waktu_operasi_menit_per_unit
 */
class RoutingDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'routing_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['urutan', 'nama_proses', 'tenaga_kerja_id', 'waktu_setup_menit', 'waktu_pengerjaan_menit'], 'required'],
            [['routing_id', 'urutan', 'mesin_id', 'tenaga_kerja_id', 'waktu_setup_menit', 'waktu_pengerjaan_menit'], 'integer'],
            [['mesin_id', 'routing_id'], 'safe'],
            [['nama_proses'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'routing_detail_id' => 'Routing Detail ID',
            'routing_id' => 'Routing ID',
            'urutan' => 'Urutan',
            'nama_proses' => 'Nama Proses',
            'mesin_id' => 'Mesin ID',
            'tenaga_kerja_id' => 'Tenaga Kerja ID',
            'waktu_setup_menit' => 'Waktu Setup Menit',
            'waktu_pengerjaan_menit' => 'Waktu Pengerjaan',
        ];
    }

    public function getTenagaKerja()
    {
        return $this->hasOne(TenagaKerja::class, ['tk_id' => 'tenaga_kerja_id']);
    }
    public function getMesin()
    {
        return $this->hasOne(Mesin::class, ['mesin_id' => 'mesin_id']);
    }
}
