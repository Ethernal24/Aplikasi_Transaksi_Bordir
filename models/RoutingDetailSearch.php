<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RoutingDetail;

/**
 * RoutingDetailSearch represents the model behind the search form of `app\models\RoutingDetail`.
 */
class RoutingDetailSearch extends RoutingDetail
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['routing_detail_id', 'routing_id', 'urutan', 'mesin_id', 'tenaga_kerja_id'], 'integer'],
            [['nama_proses', 'waktu_setup_menit', 'waktu_pengerjaan_menit'], 'safe'],
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
        $query = RoutingDetail::find();

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
            'routing_detail_id' => $this->routing_detail_id,
            'routing_id' => $this->routing_id,
            'urutan' => $this->urutan,
            'mesin_id' => $this->mesin_id,
            'tenaga_kerja_id' => $this->tenaga_kerja_id,
            'waktu_setup_menit' => $this->waktu_setup_menit,
            'waktu_pengerjaan_menit' => $this->waktu_pengerjaan_menit,
        ]);

        $query->andFilterWhere(['like', 'nama_proses', $this->nama_proses]);

        return $dataProvider;
    }
}
