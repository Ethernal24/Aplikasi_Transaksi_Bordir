<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\PermintaanPelanggan $model */

$this->title = 'Create Permintaan Pelanggan';
$this->params['breadcrumbs'][] = ['label' => 'Permintaan Pelanggans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="permintaan-pelanggan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
