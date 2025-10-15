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
            [['barang_id'], 'required'],
            ['barang_id', 'each', 'rule' => ['integer']],
        ];
    }
}
