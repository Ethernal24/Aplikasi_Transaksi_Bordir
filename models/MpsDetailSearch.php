<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MpsDetail;

/**
 * MpsDetailSearch represents the model behind the search form of `app\models\MpsDetail`.
 */
class MpsDetailSearch extends MpsDetail
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mps_detail_id', 'mps_id', 'minggu_ke', 'forecast', 'order_aktual', 'stok', 'rencana_produksi'], 'integer'],
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
        $query = MpsDetail::find();

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
            'mps_detail_id' => $this->mps_detail_id,
            'mps_id' => $this->mps_id,
            'minggu_ke' => $this->minggu_ke,
            'forecast' => $this->forecast,
            'order_aktual' => $this->order_aktual,
            'stok' => $this->stok,
            'rencana_produksi' => $this->rencana_produksi,
        ]);

        return $dataProvider;
    }
}
