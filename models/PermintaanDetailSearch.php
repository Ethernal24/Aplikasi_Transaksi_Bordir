<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PermintaanDetail;

/**
 * PermintaanDetailSearch represents the model behind the search form of `app\models\PermintaanDetail`.
 */
class PermintaanDetailSearch extends PermintaanDetail
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['permintaan_detail_id', 'permintaan_id', 'produk_id', 'jumlah'], 'integer'],
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
        $query = PermintaanDetail::find();

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
            'permintaan_detail_id' => $this->permintaan_detail_id,
            'permintaan_id' => $this->permintaan_id,
            'produk_id' => $this->produk_id,
            'jumlah' => $this->jumlah,
        ]);

        return $dataProvider;
    }
}
