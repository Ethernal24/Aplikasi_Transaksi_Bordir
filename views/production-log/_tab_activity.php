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
        [
            'attribute' => 'vs',
            'label' => 'Variasi',
        ],
        'stitch',
        'qty_output_total',
        'bs',
        'berat',
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
        var url = $(this).attr('value');
        
        modal.find('#modalTitle').text(title);
        modal.find('#modalContent').html('<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading...</div>');
        
        modal.modal('show')
            .find('#modalContent')
            .load(url, function() {
                // RE-BIND VALIDATOR setelah load selesai
                var form = $(this).find('form');
                if (form.length > 0 && typeof form.yiiActiveForm === 'function') {
                    form.yiiActiveForm(form.data('yiiActiveForm').attributes, form.data('yiiActiveForm').settings);
                }
            });
    });
JS;
$this->registerJs($js);
?>