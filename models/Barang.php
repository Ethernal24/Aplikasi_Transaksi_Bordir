<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "barang".
 *
 * @property int $barang_id
 * @property string $kode_barang
 * @property string $nama_barang
 * @property int $unit_id
 * @property int $stock
 * @property string $tipe_barang
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property PembelianDetail[] $pembelianDetails
 * @property Bom[] $boms
 * @property Stock[] $stocks
 * @property Unit $unit
 */
class Barang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_barang';
    }

    /**
     * {@inheritdoc}
     */

    public static function primaryKey()
    {
        return ['barang_id'];
    }
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'), // or date('Y-m-d H:i:s')
            ],
        ];
    }
    public function rules()
    {
        return [
            [['kode_barang', 'nama_barang', 'jenis', 'unit_id', 'tipe_barang', 'leadtime'], 'required'],
            [['unit_id', 'jenis', 'stok', 'leadtime', 'tipe_barang'], 'integer'],
            [['created_at', 'updated_at', 'stok'], 'safe'],
            [['kode_barang', 'nama_barang'], 'string', 'max' => 255],
            [['kode_barang'], 'unique'],
            [['unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => Unit::class, 'targetAttribute' => ['unit_id' => 'unit_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'barang_id' => 'Barang ID',
            'kode_barang' => 'Kode Barang',
            'nama_barang' => 'Nama Barang',
            'jenis' => 'jenis',
            'stok' => 'stok',
            'leadtime' => 'leadtime',
            'unit_id' => 'Satuan',
            'tipe_barang' => 'Tipe Barang',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[PembelianDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPembelianDetails()
    {
        return $this->hasMany(PembelianDetail::class, ['barang_id' => 'barang_id']);
    }

    /**
     * Gets query for [[Stocks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStocks()
    {
        return $this->hasOne(Stock::class, ['barang_id' => 'barang_id']);
    }

    /**
     * Gets query for [[Unit]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUnit()
    {
        return $this->hasOne(Unit::class, ['unit_id' => 'unit_id']);
    }

    public function getRiwayat()
    {
        return $this->hasMany(RiwayatPermintaan::class, ['barang_id' => 'barang_id']);
    }
    public function getForecast()
    {
        return $this->hasMany(Forecast::class, ['barang_id' => 'barang_id']);
    }
    public function getPermintaanDetails()
    {
        return $this->hasMany(PermintaanDetail::class, ['barang_id' => 'barang_id']);
    }
    public function getBoms()
    {
        return $this->hasMany(Bom::class, ['produk_id' => 'barang_id']);
    }
    public function getBomCustom()
    {
        return $this->hasMany(BomCustom::class, ['bahan_id' => 'barang_id']);
    }
    public function getJenisLabel()
    {
        return [
            0 => 'beli',
            1 => 'Produksi',
        ][$this->jenis] ?? '-';
    }
    public function getTipeLabel()
    {
        return [
            0 => 'Bahan Baku',
            1 => 'Setengah Jadi',
            2 => 'Barang Jadi',
            3 => 'Non-Consumable',
            4 => 'Template',
        ][$this->tipe_barang] ?? '-';
    }
    public function getRouting()
    {
        return $this->hasOne(MasterRouting::class, ['barang_id' => 'produk_id']);
    }
}
