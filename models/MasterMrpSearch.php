<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MasterMrp;

/**
 * MasterMrpSearch represents the model behind the search form of `app\models\MasterMrp`.
 */
class MasterMrpSearch extends MasterMrp
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mrp_id', 'mps_id', 'status'], 'integer'],
            [['kode_mrp'], 'string'],
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
        $query = MasterMrp::find();

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
            'mrp_id' => $this->mrp_id,
            'mps_id' => $this->mps_id,
            'status' => $this->status,
            'kode_mrp' => $this->kode_mrp,
        ]);

        return $dataProvider;
    }
}
