<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Forecast;

/**
 * ForecastSearch represents the model behind the search form of `app\models\Forecast`.
 */
class ForecastSearch extends Forecast
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['forecast_id', 'barang_id', 'mse', 'hasil_forecast'], 'integer'],
            [['metode'], 'safe'],
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
        $query = Forecast::find();

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
            'forecast_id' => $this->forecast_id,
            'barang_id' => $this->barang_id,
            'mse' => $this->mse,
            'hasil_forecast' => $this->hasil_forecast,
        ]);

        $query->andFilterWhere(['like', 'metode', $this->metode]);

        return $dataProvider;
    }
}
