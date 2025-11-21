<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\WoHeader;

/**
 * WoHeaderSearch represents the model behind the search form of `app\models\WoHeader`.
 */
class WoHeaderSearch extends WoHeader
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['wo_id', 'produk_id', 'status_wo'], 'integer'],
            [['kode_wo', 'tanggal_dibuat', 'tanggal_selesai', 'prioritas_wo'], 'safe'],
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
        $query = WoHeader::find();

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
            'wo_id' => $this->wo_id,
            'produk_id' => $this->produk_id,
            'tanggal_dibuat' => $this->tanggal_dibuat,
            'tanggal_selesai' => $this->tanggal_selesai,
            'status_wo' => $this->status_wo,
            'prioritas_wo' => $this->prioritas_wo,
        ]);

        $query->andFilterWhere(['like', 'kode_wo', $this->kode_wo]);

        return $dataProvider;
    }
}
