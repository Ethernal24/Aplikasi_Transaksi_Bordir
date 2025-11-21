<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\MasterRouting $model */

$this->title = 'Create Master Routing';
$this->params['breadcrumbs'][] = ['label' => 'Master Routings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-routing-create">



    <?= $this->render('_form', [
        'model' => $model,
        'modelDetails' => $modelDetails,
        'dataMesin' => $dataMesin,
        'dataTK' => $dataTK
    ]) ?>

</div>