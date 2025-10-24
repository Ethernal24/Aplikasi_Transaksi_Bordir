<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProdukCustomPelanggan;

/**
 * ProdukCustomPelangganSearch represents the model behind the search form of `app\models\ProdukCustomPelanggan`.
 */
class ProdukCustomPelangganSearch extends ProdukCustomPelanggan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['produk_custom_pelanggan_id', 'pelanggan_id'], 'integer'],
            [['kode_barang', 'nama_barang_custom', 'dibuat_pada', 'diupdate_pada'], 'safe'],
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
        $query = ProdukCustomPelanggan::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'produk_custom_pelanggan_id' => $this->produk_custom_pelanggan_id,
            'pelanggan_id' => $this->pelanggan_id,
            'dibuat_pada' => $this->dibuat_pada,
            'diupdate_pada' => $this->diupdate_pada,
        ]);

        $query->andFilterWhere(['like', 'kode_barang', $this->kode_barang])
            ->andFilterWhere(['like', 'nama_barang_custom', $this->nama_barang_custom]);

        return $dataProvider;
    }
}
