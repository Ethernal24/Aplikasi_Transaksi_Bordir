<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

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
 * @property int $tanggal_awal
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

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'dibuat_pada',
                'updatedAtAttribute' => 'diupdate_pada',
                'value' => new Expression('NOW()'), // gunakan CURRENT_TIMESTAMP di DB
            ],
        ];
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
            [['tanggal_awal'], 'safe'],
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
            'tanggal_awal' => 'Tanggal Awal',
        ];
    }

    public function getBarangRelasi()
    {
        if ($this->tipe === 0) {
            return $this->hasOne(Barang::class, ['barang_id' => 'barang_id']);
        } elseif ($this->tipe === 1) {

            return $this->hasOne(ProdukCustomPelanggan::class, ['produk_custom_pelanggan_id' => 'barang_id']);
        }
    }
    public function getBarangName()
    {
        if (!$this->barangRelasi) return '-';
        return $this->tipe === 0
            ? $this->barangRelasi->nama_barang
            : $this->barangRelasi->nama_barang_custom;
    }
    public function getPermintaan()
    {
        return $this->hasOne(PermintaanPelanggan::class, ['permintaan_id' => 'sumber']);
    }

    public function getBarang()
    {
        return $this->hasOne(Barang::class, ['barang_id' => 'barang_id']);
    }

    public function getTipeLabel()
    {
        $tipe = [
            '0' => 'MTS',
            '1' => 'MTO',
        ];
        return isset($tipe[$this->tipe]) ? $tipe[$this->tipe] : 'Unknown';;
    }
}
