<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "permintaan_pelanggan".
 *
 * @property int $permintaan_id
 * @property int $nama_pelanggan
 * @property string $tanggal_permintaan
 */
class PermintaanPelanggan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'permintaan_pelanggan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_pelanggan', 'tanggal_permintaan'], 'required'],
            [['nama_pelanggan'], 'string'],
            [['tanggal_permintaan'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'permintaan_id' => 'Permintaan ID',
            'nama_pelanggan' => 'Nama Pelanggan',
            'tanggal_permintaan' => 'Tanggal Permintaan',
        ];
    }

    public function getDetail()
    {
        return $this->hasMany(PermintaanDetail::class, ['permintaan_id' => 'permintaan_id']);
    }
}
