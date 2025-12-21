<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Workcenter;

/**
 * WorkcenterSearch represents the model behind the search form of `app\models\Workcenter`.
 */
class WorkcenterSearch extends Workcenter
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['workcenter_id'], 'integer'],
            [['kode_workcenter', 'nama_workcenter', 'tipe_kapasitas', 'keterangann'], 'safe'],
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
        $query = Workcenter::find();

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
            'workcenter_id' => $this->workcenter_id,
        ]);

        $query->andFilterWhere(['like', 'kode_workcenter', $this->kode_workcenter])
            ->andFilterWhere(['like', 'nama_workcenter', $this->nama_workcenter])
            ->andFilterWhere(['like', 'tipe_kapasitas', $this->tipe_kapasitas])
            ->andFilterWhere(['like', 'keterangann', $this->keterangann]);

        return $dataProvider;
    }
}
