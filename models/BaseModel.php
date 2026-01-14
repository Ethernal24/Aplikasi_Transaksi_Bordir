<?php

namespace app\models;

use yii\db\ActiveRecord;

class BaseModel extends ActiveRecord
{
    public static function generateAutoNumber($prefix, $attribute, $padLength = 4)
    {
        // Mencari record terakhir dengan prefix yang sama
        $last = static::find()
            ->select([$attribute])
            ->where(['like', $attribute, $prefix . '-%', false])
            // Gunakan LENGTH untuk memastikan nomor dengan digit lebih banyak berada di atas
            // Atau urutkan berdasarkan ID jika ID bersifat auto-increment
            ->orderBy([
                new \yii\db\Expression("LENGTH($attribute) DESC"),
                $attribute => SORT_DESC
            ])
            ->one();

        $nextNumber = 1;

        if ($last) {
            // Gunakan preg_match untuk mengambil angka di akhir string agar lebih aman
            if (preg_match('/-(\d+)$/', $last->$attribute, $matches)) {
                $lastNumber = (int) $matches[1];
                $nextNumber = $lastNumber + 1;
            }
        }

        return $prefix . '-' . str_pad($nextNumber, $padLength, '0', STR_PAD_LEFT);
    }
}
