<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\WorkOrder;
use yii\db\Expression;

/**
 * WorkOrderSearch represents the model behind the search form of `app\models\WorkOrder`.
 */
class WorkOrderSearch extends WorkOrder
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_wo', 'permintaan_id', 'id_routing', 'qty_target', 'status_wo', 'prioritas'], 'integer'],
            [['kode_wo', 'tanggal_wo', 'due_date', 'created_at', 'updated_at'], 'safe'],
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
        $query = WorkOrder::find();
        $statusOrder = new Expression("
    CASE 
        WHEN status_wo IN (3, 4) THEN 1 
        ELSE 0 
    END
");

        $query->addSelect([
            'workorder.*', // Gunakan nama_tabel.* agar lebih aman
            'is_finished' => $statusOrder
        ]);

        // HAPUS ATAU KOMENTARI BARIS DI BAWAH INI:
        // ->andWhere(['not in', 'status_wo', [3, 4]]); 

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'prioritas',
                    'status_wo',
                    'due_date',
                    'is_finished' => [
                        'asc' => ['is_finished' => SORT_ASC],
                        'desc' => ['is_finished' => SORT_DESC],
                        'label' => 'Status Selesai',
                    ],
                ],
                'defaultOrder' => [
                    'is_finished' => SORT_ASC, // Ini yang memastikan 3 & 4 masuk grup bawah
                    'prioritas'   => SORT_DESC,
                    'due_date'    => SORT_ASC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_wo' => $this->id_wo,
            'permintaan_id' => $this->permintaan_id,
            'id_routing' => $this->id_routing,
            'qty_target' => $this->qty_target,
            'tanggal_wo' => $this->tanggal_wo,
            'due_date' => $this->due_date,
            'status_wo' => $this->status_wo,
            'prioritas' => $this->prioritas,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'kode_wo', $this->kode_wo]);

        return $dataProvider;
    }
}
