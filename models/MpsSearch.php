<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Mps;

/**
 * MpsSearch represents the model behind the search form of `app\models\Mps`.
 */
class MpsSearch extends Mps
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mps_id', 'barang_id', 'periode', 'qty', 'tipe', 'dateline', 'sumber', 'status_mps'], 'integer'],
            [['dateline'], 'safe']


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
        $query = Mps::find();

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
            'mps_id' => $this->mps_id,
            'barang_id' => $this->barang_id,
            'periode' => $this->periode,
            'qty' => $this->qty,
            'tipe' => $this->tipe,
            'dateline' => $this->dateline,
            'sumber' => $this->sumber,
            'status_mps' => $this->status_mps,
        ]);

        return $dataProvider;
    }
}
