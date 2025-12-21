<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Shift;

/**
 * Shiftsearch represents the model behind the search form of `app\models\Shift`.
 */
class Shiftsearch extends Shift
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jam_efektif',], 'integer'],
            [['jam_mulai', 'jam_selesai', 'nama_shift'], 'safe'],
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
        $query = Shift::find();

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
            'nama_shift' => $this->nama_shift,
            'jam_mulai' => $this->jam_mulai,
            'jam_selesai' => $this->jam_selesai,
            'jam_efektif' => $this->jam_efektif,
        ]);

        return $dataProvider;
    }
}
