<?php

namespace app\helpers;

use Yii;
use yii\helpers\ArrayHelper;

class ModelHelper
{
    public static function createMultiple($modelClass, $multipleModels = [], $indexKey = 'id')
    {
        $model = new $modelClass;
        $formName = $model->formName();
        $post = Yii::$app->request->post($formName);
        $models = [];

        // Bangun array model lama, jika tersedia
        $indexedModels = [];
        if (!empty($multipleModels)) {
            foreach ($multipleModels as $m) {
                if (isset($m->{$indexKey})) {
                    $indexedModels[$m->{$indexKey}] = $m;
                }
            }
        }

        if ($post && is_array($post)) {
            foreach ($post as $i => $item) {
                if (isset($item[$indexKey]) && !empty($item[$indexKey]) && isset($indexedModels[$item[$indexKey]])) {
                    // Gunakan model lama
                    $models[] = $indexedModels[$item[$indexKey]];
                } else {
                    // Buat model baru
                    $models[] = new $modelClass;
                }
            }
        } else {
            // Jika belum ada data POST, tampilkan model lama
            $models = $multipleModels;
        }

        return $models;
    }
}
