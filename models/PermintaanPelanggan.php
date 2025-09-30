<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "permintaan_pelanggan".
 *
 * @property int $permintaan_id
 * @property int $jumlah
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
            [['jumlah', 'tanggal_permintaan'], 'required'],
            [['jumlah'], 'integer'],
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
            'jumlah' => 'Jumlah',
            'tanggal_permintaan' => 'Tanggal Permintaan',
        ];
    }
}
