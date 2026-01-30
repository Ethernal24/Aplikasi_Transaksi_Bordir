<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MpsDetailAllocation;

/**
 * MpsDetailAllocationSearch represents the model behind the search form of `app\models\MpsDetailAllocation`.
 */
class MpsDetailAllocationSearch extends MpsDetailAllocation
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mps_detail_allocation_id', 'mps_detail_id', 'workcenter_id', 'qty_mesin_alokasi', 'qty_karyawan_alokasi'], 'integer'],
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
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = MpsDetailAllocation::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'mps_detail_allocation_id' => $this->mps_detail_allocation_id,
            'mps_detail_id' => $this->mps_detail_id,
            'workcenter_id' => $this->workcenter_id,
            'qty_mesin_alokasi' => $this->qty_mesin_alokasi,
            'qty_karyawan_alokasi' => $this->qty_karyawan_alokasi,
        ]);

        return $dataProvider;
    }
}
