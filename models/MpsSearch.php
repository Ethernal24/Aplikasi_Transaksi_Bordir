<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Mps;

/**
 * MpsSearch represents the model behind the search form of `app\models\Mps`.
 */
class MpsSearch extends Mps
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mps_id', 'forecast_id', 'stock_awal', 'rencana_produksi'], 'integer'],
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
        $query = Mps::find();

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
            'mps_id' => $this->mps_id,
            'forecast_id' => $this->forecast_id,
            'stock_awal' => $this->stock_awal,
            'rencana_produksi' => $this->rencana_produksi,
        ]);

        return $dataProvider;
    }
}
