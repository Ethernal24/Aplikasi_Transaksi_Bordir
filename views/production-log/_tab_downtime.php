<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<?= GridView::widget([
    'dataProvider' => $downtimeProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        // 'downtime_id',
        'log_id',
        'ganti_benang',
        'ganti_kain',
        'kendala',
        'durasi_menit',
    ],
]); ?>
<div class="d-flex justify-content-between mb-3">
    <?= Html::button('<i class="fas fa-plus"></i> Tambah Kendala', [
        'value' => Url::to(['/production-log-downtime/create', 'log_id' => $model->id_log]),
        'class' => 'btn btn-success btn-modal-trigger', // Gunakan class agar mudah ditangkap JS
        'data-title' => 'Tambah Detail Kendala' // Judul kustom
    ]) ?>
</div>

<?php
$js = <<<JS
    $('.btn-modal-trigger').on('click', function(){
        var modal = $('#modal-universal');
        var title = $(this).attr('data-title');
        
        modal.find('#modalTitle').text(title); // Ganti judul modal
        modal.find('#modalContent').html('<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading...</div>');
        
        modal.modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
    });
JS;
$this->registerJs($js);
?>