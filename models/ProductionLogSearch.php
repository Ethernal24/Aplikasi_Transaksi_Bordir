<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProductionLog;

/**
 * ProductionLogSearch represents the model behind the search form of `app\models\ProductionLog`.
 */
class ProductionLogSearch extends ProductionLog
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['production_log_id', 'tk_id', 'shift_id', 'mesin_id'], 'integer'],
            [['tanggal', 'mulai_istirahat', 'selesai_istirahat'], 'safe'],
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
        $query = ProductionLog::find();

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
            'production_log_id' => $this->production_log_id,
            'tanggal' => $this->tanggal,
            'mesin_id' => $this->mesin_id,
            'tk_id' => $this->tk_id,
            'shift_id' => $this->shift_id,
            'waktu_kerja' => $this->waktu_kerja,
            'mulai_istirahat' => $this->mulai_istirahat,
            'selesai_istirahat' => $this->selesai_istirahat,
        ]);

        return $dataProvider;
    }
}
