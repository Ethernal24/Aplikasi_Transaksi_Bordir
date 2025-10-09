<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RiwayatPermintaan;

/**
 * RiwayatPermintaanSearch represents the model behind the search form of `app\models\RiwayatPermintaan`.
 */
class RiwayatPermintaanSearch extends RiwayatPermintaan
{
    /**
     * {@inheritdoc}
     */
    public $nama_barang;
    public function rules()
    {
        return [
            [['riwayat_id', 'barang_id', 'tahun', 'jumlah_permintaan'], 'integer'],
            [['nama_barang', 'bulan'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = RiwayatPermintaan::find();
        $query->joinWith(['barang']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 15, // Jumlah item per halaman
            ],
            'sort' => [
                'attributes' => [
                    'nama_barang',
                    'bulan',
                    'tahun',
                    'jumlah_permintaan',
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'riwayat_id' => $this->riwayat_id,
            'barang_id' => $this->barang_id,
            'tahun' => $this->tahun,
            'jumlah_permintaan' => $this->jumlah_permintaan,
        ]);

        $query->andFilterWhere(['like', 'bulan', $this->bulan]);
        $query->andFilterWhere(['like', 'barang.nama_barang', $this->nama_barang]);
        return $dataProvider;
    }
}
