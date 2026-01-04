<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProductionLogAttendance;

/**
 * ProductionLogAttendanceSearch represents the model behind the search form of `app\models\ProductionLogAttendance`.
 */
class ProductionLogAttendanceSearch extends ProductionLogAttendance
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['attendance_id', 'tk_id', 'log_id'], 'integer'],
            [['mulai_kerja', 'selesai_kerja', 'mulai_istirahat', 'selesai_istirahat'], 'safe'],
            [['waktu_kerja'], 'number'],
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
        $query = ProductionLogAttendance::find();

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
            'attendance_id' => $this->attendance_id,
            'tk_id' => $this->tk_id,
            'log_id' => $this->log_id,
            'mulai_kerja' => $this->mulai_kerja,
            'selesai_kerja' => $this->selesai_kerja,
            'waktu_kerja' => $this->waktu_kerja,
            'mulai_istirahat' => $this->mulai_istirahat,
            'selesai_istirahat' => $this->selesai_istirahat,
        ]);

        return $dataProvider;
    }
}
