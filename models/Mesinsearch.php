<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Mesin;

/**
 * Mesinsearch represents the model behind the search form of `app\models\Mesin`.
 */
class Mesinsearch extends Mesin
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mesin_id', 'workcenter_id', 'max_kapasitas_operasi_hari', 'status_mesin'], 'integer'],
            [['nama_mesin', 'deskripsi' . 'tipe_mesin', 'kode_mesin'], 'safe'],
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
        $query = Mesin::find();

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
            'mesin_id' => $this->mesin_id,
        ]);

        $query->andFilterWhere(['like', 'nama_mesin', $this->nama_mesin])
            ->andFilterWhere(['like', 'deskripsi', $this->deskripsi]);

        return $dataProvider;
    }
}
