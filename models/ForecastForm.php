<?php

namespace app\models;

use yii\base\Model;

class ForecastForm extends Model
{
    public $barang_id;
    public $periode;
    public $horizon;

    public function rules()
    {
        return [
            [['barang_id', 'periode', 'horizon'], 'required'],
            ['periode', 'integer', 'min' => 2],
            ['horizon', 'integer'],
            ['barang_id', 'each', 'rule' => ['integer']],
        ];
    }
}
