<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\JadwalSimulasi;

/**
 * JadwalSimulasiSearch represents the model behind the search form of `app\models\JadwalSimulasi`.
 */
class JadwalSimulasiSearch extends JadwalSimulasi
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['simulasi_id', 'produk_id', 'quantity'], 'integer'],
            [['tanggal_mulai', 'dateline', 'estimasi_selesai', 'pelanggan_id'], 'safe'],
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
        $query = JadwalSimulasi::find();

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
            'simulasi_id' => $this->simulasi_id,
            'pelanggan_id' => $this->pelanggan_id,
            'produk_id' => $this->produk_id,
            'quantity' => $this->quantity,
            'tanggal_mulai' => $this->tanggal_mulai,
            'dateline' => $this->dateline,
            'estimasi_selesai' => $this->estimasi_selesai,
        ]);

        return $dataProvider;
    }
}
