<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\WorkorderMaterial;

/**
 * WorkorderMaterialSearch represents the model behind the search form of `app\models\WorkorderMaterial`.
 */
class WorkorderMaterialSearch extends WorkorderMaterial
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['wo_mat_id', 'wo_id', 'bahan_id', 'qty_plan', 'qty_aktual', 'status_pengambilan_bahan'], 'integer'],
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
        $query = WorkorderMaterial::find();

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
            'wo_mat_id' => $this->wo_mat_id,
            'wo_id' => $this->wo_id,
            'bahan_id' => $this->bahan_id,
            'qty_plan' => $this->qty_plan,
            'qty_aktual' => $this->qty_aktual,
            'status_pengambilan_bahan' => $this->status_pengambilan_bahan,
        ]);

        return $dataProvider;
    }
}
