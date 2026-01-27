<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<?= GridView::widget([
    'dataProvider' => $detailProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        // 'activity_id' => 'Activity ID',
        // 'log_id',
        // 'activity_id',
        'vs',
        'stitch',
        'kuantitas',
        'bs',
        'berat',
    ],
]); ?>
<div class="d-flex justify-content-between mb-3">
    <?= Html::button('<i class="fas fa-plus"></i> Tambah Detail', [
        'value' => Url::to(['/production-log-detail/create', 'log_id' => $model->id_log]),
        'class' => 'btn btn-success btn-modal-trigger', // Gunakan class agar mudah ditangkap JS
        'data-title' => 'Tambah Detail Produksi' // Judul kustom
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