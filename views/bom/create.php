<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Bom $model */

$this->title = 'Create Bom';
$this->params['breadcrumbs'][] = ['label' => 'Boms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pc-content">



    <?= $this->render('_form', [
        'modelBoms' => $modelBoms,
    ]) ?>

</div>