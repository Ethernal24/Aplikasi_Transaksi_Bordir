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
class MasterRouting extends BaseModel
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
            [['nama_routing', 'kode_routing'], 'required'],
            [['produk_id'], 'integer'],
            [['nama_routing', 'kode_routing'], 'string', 'max' => 255],
            [['kode_routing'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'routing_id' => 'Routing ID',
            'kode_routing' => 'Kode Routing',
            'produk_id' => 'produk ID',
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
