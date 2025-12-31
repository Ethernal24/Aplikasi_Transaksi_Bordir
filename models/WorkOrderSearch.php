<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\WorkOrder;

/**
 * WorkOrderSearch represents the model behind the search form of `app\models\WorkOrder`.
 */
class WorkOrderSearch extends WorkOrder
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_wo', 'permintaan_detail_id', 'id_routing', 'qty_target', 'qty_aktual', 'status_wo', 'prioritas'], 'integer'],
            [['kode_wo', 'tanggal_wo', 'due_date', 'created_at', 'updated_at'], 'safe'],
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
        $query = WorkOrder::find();

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
            'id_wo' => $this->id_wo,
            'permintaan_detail_id' => $this->permintaan_detail_id,
            'id_routing' => $this->id_routing,
            'qty_target' => $this->qty_target,
            'qty_aktual' => $this->qty_aktual,
            'tanggal_wo' => $this->tanggal_wo,
            'due_date' => $this->due_date,
            'status_wo' => $this->status_wo,
            'prioritas' => $this->prioritas,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'kode_wo', $this->kode_wo]);

        return $dataProvider;
    }
}
