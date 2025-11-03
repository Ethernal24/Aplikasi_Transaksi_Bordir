<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MrpDetail;

/**
 * MrpDetailSearch represents the model behind the search form of `app\models\MrpDetail`.
 */
class MrpDetailSearch extends MrpDetail
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mrp_detail_id', 'kebutuhan_kotor', 'minggu_ke', 'mrp_id', 'barang_id', 'stock_tersedia', 'kebutuhan_bersih', 'leadtime', 'planned_order_release', 'planned_order_receipt'], 'integer'],
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
        $query = MrpDetail::find();

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
            'mrp_detail_id' => $this->mrp_detail_id,
            'mrp_id' => $this->mrp_id,
            'barang_id' => $this->barang_id,
            'minggu_ke' => $this->minggu_ke,
            'kebutuhan_kotor' => $this->kebutuhan_kotor,
            'stock_tersedia' => $this->stock_tersedia,
            'kebutuhan_bersih' => $this->kebutuhan_bersih,
            'leadtime' => $this->leadtime,
            'planned_order_release' => $this->planned_order_release,
            'planned_order_receipt' => $this->planned_order_receipt,
        ]);

        return $dataProvider;
    }
}
