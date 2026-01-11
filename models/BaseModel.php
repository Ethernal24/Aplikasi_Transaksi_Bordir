<?php

namespace app\models;

use yii\db\ActiveRecord;

class BaseModel extends ActiveRecord
{
    public static function generateAutoNumber($prefix, $attribute, $padLength = 4)
    {
        $last = static::find()
            ->select([$attribute])
            ->where(['like', $attribute, $prefix . '-%', false])
            ->orderBy([$attribute => SORT_DESC])
            ->one();
        $nextNumber = 1;
        if ($last) {
            $parts = explode('-', $last->$attribute);
            $lastNumber = (int) end($parts);
            $nextNumber = $lastNumber + 1;
        }
        return $prefix . '-' . str_pad($nextNumber, $padLength, '0', STR_PAD_LEFT);
    }
}
