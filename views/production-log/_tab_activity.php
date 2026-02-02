<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<?= GridView::widget([
    'dataProvider' => $activityProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        // 'activity_id' => 'Activity ID',
        // 'id_log',
        [
            'attribute' => 'id_routing_detail',
            'label' => 'Proses Produksi',
            'value' => function ($model) {
                // $model di sini adalah ProductionLogActivity
                // Kita panggil relasi detailRouting, lalu ambil deskripsi_kerja
                return $model->detailRouting ?
                    $model->detailRouting->deskripsi_kerja :
                    '(Tanpa Nama Proses)';
            },
        ],
        'qty_output_total',
        'durasi_menit',
    ],
]); ?>
<div class="d-flex justify-content-between mb-3">
    <?= Html::button('<i class="fas fa-plus"></i> Tambah Activity', [
        'value' => Url::to(['/production-log-activity/create', 'id_log' => $model->id_log]),
        'class' => 'btn btn-success btn-modal-trigger', // Gunakan class agar mudah ditangkap JS
        'data-title' => 'Tambah Activity' // Judul kustom
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