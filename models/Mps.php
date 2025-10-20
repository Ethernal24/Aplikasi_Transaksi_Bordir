<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mps".
 *
 * @property int $mps_id
 * @property int $barang_id
 * @property int $periode
 * @property int $qty
 * @property int $tipe
 * @property int $sumber
 * @property int $status_mps
 * @property string $dateline
 */
class Mps extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mps';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['barang_id', 'periode', 'qty', 'tipe', 'dateline', 'sumber', 'status_mps'], 'required'],
            [['barang_id', 'tipe', 'status_mps', 'sumber'], 'integer'],
            [['qty'], 'number'],
            [['rencana_produksi'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'mps_id' => 'Mps ID',
            'barang_id' => "Barang ID",
            'periode' => "Periode",
            'qty' => "Qty",
            'tipe' => "Tipe",
            'dateline' => "Dateline",
            'sumber' => "Sumber",
            'status_mps' => "Status MPS",
        ];
    }

    public function getBarang()
    {
        return $this->hasOne(Barang::class, ['barang_id' => 'barang_id']);
    }
}
