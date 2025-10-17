<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "master_pelanggan".
 *
 * @property int $pelanggan_id
 * @property string $nama_pelanggan
 * @property string $instansi
 * @property string|null $pesenan_terakhir
 */
class MasterPelanggan extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_pelanggan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pesenan_terakhir'], 'default', 'value' => null],
            [['nama_pelanggan', 'instansi'], 'required'],
            [['pesenan_terakhir'], 'safe'],
            [['nama_pelanggan', 'instansi'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pelanggan_id' => 'Pelanggan ID',
            'nama_pelanggan' => 'Nama Pelanggan',
            'instansi' => 'Instansi',
            'pesenan_terakhir' => 'Pesenan Terakhir',
        ];
    }

}
