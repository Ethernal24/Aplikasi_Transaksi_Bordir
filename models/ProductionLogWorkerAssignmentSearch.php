<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProductionLogWorkerAssignment;

/**
 * ProductionLogWorkerAssignmentSearch represents the model behind the search form of `app\models\ProductionLogWorkerAssignment`.
 */
class ProductionLogWorkerAssignmentSearch extends ProductionLogWorkerAssignment
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_assignment', 'id_tk', 'id_workcenter', 'id_shift', 'id_wo'], 'integer'],
            [['tanggal_assignment'], 'safe'],
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
        $query = ProductionLogWorkerAssignment::find();

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
            'id_assignment' => $this->id_assignment,
            'tanggal_assignment' => $this->tanggal_assignment,
            'id_tk' => $this->id_tk,
            'id_workcenter' => $this->id_workcenter,
            'id_shift' => $this->id_shift,
            'id_wo' => $this->id_wo,
        ]);

        return $dataProvider;
    }
}
