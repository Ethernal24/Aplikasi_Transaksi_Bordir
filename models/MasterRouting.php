<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "master_routing".
 *
 * @property int $routing_id
 * @property string $nama_routing
 * @property string $deskripsi
 */
class MasterRouting extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_routing';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_routing'], 'required'],
            [['produk_id'], 'integer'],
            [['nama_routing'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'routing_id' => 'Routing ID',
            'nama_routing' => 'Nama Routing',
        ];
    }

    public function getDetails()
    {
        return $this->hasMany(RoutingDetail::class, ['routing_id' => 'routing_id']);
    }

    public function getProduk()
    {
        return $this->hasOne(Barang::class, ['barang_id' => 'produk_id']);
    }
}
