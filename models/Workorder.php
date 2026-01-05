<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "workorder".
 *
 * @property int $id_wo
 * @property string $kode_wo
 * @property int $permintaan_detail_id
 * @property int $id_routing
 * @property int $qty_target
 * @property int $qty_aktual
 * @property string $tanggal_wo
 * @property string $due_date
 * @property int $status_wo
 * @property int $prioritas
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Workorder extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'workorder';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_wo', 'permintaan_id',  'id_routing', 'qty_target', 'tanggal_wo', 'due_date', 'status_wo', 'prioritas', 'id_mps', 'id_produk'], 'required'],
            [['id_routing', 'qty_target', 'status_wo', 'prioritas', 'id_mps', 'id_produk'], 'integer'],
            [['tanggal_wo', 'due_date', 'created_at', 'updated_at'], 'safe'],
            [['kode_wo'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_wo' => 'Id Wo',
            'kode_wo' => 'Kode Wo',
            'id_mps' => 'ID MPS',
            'permintaan_id' => 'Permintaan ID',
            'id_routing' => 'ID Routing',
            'qty_target' => 'Qty Target',
            'id_produk' => 'ID Produk',
            'tanggal_wo' => 'Tanggal Wo',
            'due_date' => 'Due Date',
            'status_wo' => 'Status Wo',
            'prioritas' => 'Prioritas',
            'created_at' => 'Created At',
            'updated_at' => 'Update At',
        ];
    }

    public function getProduk()
    {
        return $this->hasOne(Barang::class, ['barang_id' => 'id_produk'])->alias('Produk');
    }
    public function getMps()
    {
        return $this->hasOne(Mps::class, ['mps_id' => 'id_mps']);
    }
    public function getRouting()
    {
        return $this->hasOne(MasterRouting::class, ['routing_id' => 'id_routing']);
    }
    public function getPermintaan()
    {
        return $this->hasOne(PermintaanPelanggan::class, ['permintaan_id' => 'permintaan_id']);
    }
    public function getWoMat()
    {
        return $this->hasMany(WorkorderMaterial::class, ['wo_id' => 'id_wo']);
    }
    public function getLabelStatus()
    {
        $status = [
            '0' => [
                'label' => 'Rilis',
                'class' => 'badge bg-primary'
            ],
            '1' => [
                'label' => 'Berjalan',
                'class' => 'badge bg-warning'
            ],
            '2' => [
                'label' => 'Selesai',
                'class' => 'badge bg-success'
            ],
            '3' => [
                'label' => 'Batal',
                'class' => 'badge bg-danger'
            ],
        ];
        return isset($status[$this->status_wo]) ? $status[$this->status_wo] : ['label' => 'unknown', 'class' => 'badge bg-secondary'];
    }
    public function getLabelPrioritas()
    {
        $status = [
            '0' => [
                'label' => 'Low',
                'class' => 'badge bg-secondary'
            ],
            '1' => [
                'label' => 'Medium',
                'class' => 'badge bg-primary'
            ],
            '2' => [
                'label' => 'High',
                'class' => 'badge bg-warning'
            ],
            '3' => [
                'label' => 'Urgent',
                'class' => 'badge bg-danger'
            ],
        ];
        return isset($status[$this->prioritas]) ? $status[$this->prioritas] : ['label' => 'unknown', 'class' => 'badge bg-secondary'];
    }
}
