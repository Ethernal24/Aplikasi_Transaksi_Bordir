<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProductionLogActivity;

/**
 * ProductionLogActivitySearch represents the model behind the search form of `app\models\ProductionLogActivity`.
 */
class ProductionLogActivitySearch extends ProductionLogActivity
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['activity_id', 'log_id', 'ganti_benang', 'ganti_kain', 'durasi_menit'], 'integer'],
            [['kendala'], 'safe'],
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
        $query = ProductionLogActivity::find();

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
            'activity_id' => $this->activity_id,
            'log_id' => $this->log_id,
            'ganti_benang' => $this->ganti_benang,
            'ganti_kain' => $this->ganti_kain,
            'durasi_menit' => $this->durasi_menit,
        ]);

        $query->andFilterWhere(['like', 'kendala', $this->kendala]);

        return $dataProvider;
    }
}
