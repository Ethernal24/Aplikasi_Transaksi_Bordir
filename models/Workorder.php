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
            [['kode_wo', 'permintaan_detail_id',  'id_routing', 'qty_target', 'tanggal_wo', 'due_date', 'status_wo', 'prioritas', 'permintaan_id'], 'required'],
            [['id_routing', 'qty_target', 'status_wo', 'prioritas', 'permintaan_id'], 'integer'],
            [['tanggal_wo', 'due_date', 'created_at', 'updated_at', 'qty_aktual'], 'safe'],
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
            'permintaan_id' => 'Permintaan ID',
            'permintaan_detail_id' => 'Permintaan Detail ID',
            'id_routing' => 'Id Routing',
            'qty_target' => 'Qty Target',
            'qty_aktual' => 'Qty Aktual',
            'tanggal_wo' => 'Tanggal Wo',
            'due_date' => 'Due Date',
            'status_wo' => 'Status Wo',
            'prioritas' => 'Prioritas',
            'created_at' => 'Created At',
            'updated_at' => 'Update At',
        ];
    }

    public function getRouting()
    {
        return $this->hasOne(MasterRouting::class, ['routing_id' => 'id_routing']);
    }
    public function getPermintaanDetail()
    {
        return $this->hasOne(PermintaanDetail::class, ['permintaan_detail_id' => 'permintaan_detail_id']);
    }
    public function getPermintaan()
    {
        return $this->hasOne(PermintaanPelanggan::class, ['permintaan_id' => 'permintaan_id']);
    }

    public function getLabelStatus()
    {
        $status = [
            '0' => [
                'label' => 'Draft',
                'class' => 'badge bg-secondary'
            ],
            '1' => [
                'label' => 'Rilis',
                'class' => 'badge bg-primary'
            ],
            '2' => [
                'label' => 'Berjalan',
                'class' => 'badge bg-warning'
            ],
            '3' => [
                'label' => 'Selesai',
                'class' => 'badge bg-success'
            ],
            '4' => [
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
        return isset($status[$this->status_wo]) ? $status[$this->status_wo] : ['label' => 'unknown', 'class' => 'badge bg-secondary'];
    }
}
