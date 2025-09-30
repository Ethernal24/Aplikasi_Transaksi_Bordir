<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PermintaanPelanggan;

/**
 * PermintaanPelangganSearch represents the model behind the search form of `app\models\PermintaanPelanggan`.
 */
class PermintaanPelangganSearch extends PermintaanPelanggan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['permintaan_id', 'jumlah'], 'integer'],
            [['tanggal_permintaan'], 'safe'],
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
        $query = PermintaanPelanggan::find();

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
            'permintaan_id' => $this->permintaan_id,
            'jumlah' => $this->jumlah,
            'tanggal_permintaan' => $this->tanggal_permintaan,
        ]);

        return $dataProvider;
    }
}
