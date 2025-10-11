<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TenagaKerja;

/**
 * TenagaKerjaSearch represents the model behind the search form of `app\models\TenagaKerja`.
 */
class TenagaKerjaSearch extends TenagaKerja
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tk_id', 'status_kerja'], 'integer'],
            [['nama', 'jabatan', 'kemampuan', 'dibuat_pada', 'diupdate_pada'], 'safe'],
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
        $query = TenagaKerja::find();

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
            'tk_id' => $this->tk_id,
            'status_kerja' => $this->status_kerja,
            'dibuat_pada' => $this->dibuat_pada,
            'diupdate_pada' => $this->diupdate_pada,
        ]);

        $query->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'jabatan', $this->jabatan])
            ->andFilterWhere(['like', 'kemampuan', $this->kemampuan]);

        return $dataProvider;
    }
}
