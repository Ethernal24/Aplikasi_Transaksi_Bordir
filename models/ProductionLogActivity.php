<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "production_log_activity".
 *
 * @property int $activity_id
 * @property int $log_id
 * @property int|null $ganti_benang
 * @property int|null $ganti_kain
 * @property string|null $kendala
 * @property int $durasi_menit
 */
class ProductionLogActivity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'production_log_activity';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_log', 'id_routing_detail', 'qty_output_total'], 'required'],
            [['id_log', 'id_routing_detail', 'qty_output_total'], 'integer'],
            [['durasi_menit', 'created_at'], 'safe'],
            [['durasi_menit'], 'number']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'activity_id' => 'Activity ID',
            'id_log' => 'ID Log',
            'id_routing_detail' => 'ID Routing Detail',
            'qty_output_total' => 'Qty Output Total',
            'durasi_menit' => 'Durasi Menit',
            'created_at' => 'Dibuat Pada',
        ];
    }

    public function getLog()
    {
        return $this->hasOne(ProductionLog::class, ['id_log' => 'id_log']);
    }
    public function getDetailRouting()
    {
        return $this->hasOne(RoutingDetail::class, ['routing_detail_id' => 'id_routing_detail']);
    }
}
