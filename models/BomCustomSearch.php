<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BomCustom;

/**
 * BomCustomSearch represents the model behind the search form of `app\models\BomCustom`.
 */
class BomCustomSearch extends BomCustom
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bom_custom_id', 'permintaan_detail_id', 'bahan_id', 'unit_id', 'catatan'], 'integer'],
            [['qty_per_unit'], 'number'],
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
        $query = BomCustom::find();

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
            'bom_custom_id' => $this->bom_custom_id,
            'permintaan_detail_id' => $this->permintaan_detail_id,
            'bahan_id' => $this->bahan_id,
            'qty_per_unit' => $this->qty_per_unit,
            'unit_id' => $this->unit_id,
            'catatan' => $this->catatan,
        ]);

        return $dataProvider;
    }
}
