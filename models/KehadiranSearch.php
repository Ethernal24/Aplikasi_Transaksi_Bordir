<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Kehadiran;

/**
 * KehadiranSearch represents the model behind the search form of `app\models\Kehadiran`.
 */
class KehadiranSearch extends Kehadiran
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kehadiran_id', 'tk_id', 'shift_id', 'status_kehadiran'], 'integer'],
            [['tanggal', 'jam_masuk_real', 'jam_pulang_real'], 'safe'],
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
        $query = Kehadiran::find();

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
            'kehadiran_id' => $this->kehadiran_id,
            'tanggal' => $this->tanggal,
            'tk_id' => $this->tk_id,
            'shift_id' => $this->shift_id,
            'status_kehadiran' => $this->status_kehadiran,
            'jam_masuk_real' => $this->jam_masuk_real,
            'jam_pulang_real' => $this->jam_pulang_real,
        ]);

        return $dataProvider;
    }
}
