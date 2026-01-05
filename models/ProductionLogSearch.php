<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProductionLog;

/**
 * ProductionLogSearch represents the model behind the search form of `app\models\ProductionLog`.
 */
class ProductionLogSearch extends ProductionLog
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_wo', 'id_workcenter', 'id_shift', 'status'], 'integer'],
            [['kode_log'], 'string'],
            [['tanggal'], 'safe'],
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
        $query = ProductionLog::find();

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
            'kode_log' => $this->kode_log,
            'id_wo' => $this->id_wo,
            'id_workcenter' => $this->id_workcenter,
            'id_shift' => $this->id_shift,
            'tanggal' => $this->tanggal,
            'status' => $this->status,
        ]);

        return $dataProvider;
    }
}
