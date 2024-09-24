<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "laporanproduksi".
 *
 * @property int $laporan_id
 * @property int $mesin_id
 * @property int $shift_id
 * @property string $tanggal_kerja
 * @property string $nama_kerjaan
 * @property int $vs
 * @property int $stitch
 * @property int $kuantitas
 * @property int $bs
 *
 * @property Mesin $mesin
 * @property Shift $shift
 */
class LaporanAgregat extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'laporanproduksi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tanggal_kerja', 'nama_kerjaan','kuantitas'], 'required'],
            [[ 'kuantitas'], 'integer'],
            [['tanggal_kerja'], 'safe'],
            [['nama_kerjaan'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tanggal_kerja' => 'Tanggal Kerja',
            'nama_kerjaan' => 'Nama Kerjaan',
            'kuantitas' => 'Kuantitas',
        ];
    }

    public static function getMonthlyAggregatedData()
    {
        $subquery = (new \yii\db\Query())
        ->select([
            'nama',
            'SUM(qty) AS total_keluar_qty'
        ])
        ->from('laporan_keluar')
        ->groupBy(['nama']);

 
        return self::find()
            ->select([
                'MONTH(tanggal_kerja) AS month',
                'YEAR(tanggal_kerja) AS year',
                'nama_kerjaan',
                'SUM(kuantitas) - COALESCE(lk.total_keluar_qty, 0) AS total_kuantitas'
            ])
            ->leftJoin(['lk' => $subquery], 'lk.nama = laporanproduksi.nama_kerjaan')
            ->groupBy(['MONTH(tanggal_kerja)', 'YEAR(tanggal_kerja)', 'nama_kerjaan'])
            ->asArray()
            ->all();
        
    }
}