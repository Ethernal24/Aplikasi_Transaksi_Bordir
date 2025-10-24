<?php

use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;


/** @var yii\web\View $this */
/** @var app\models\MasterPelanggan $model */

$this->title = "Data Pelanggan : " . $model->nama_pelanggan;
$this->params['breadcrumbs'][] = ['label' => 'Master Pelanggans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pc-content">
    <div class="card card-table">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="row mx-3">
            <div class="col">
                <div><strong>Nama Pelanggan : </strong><?= $model->nama_pelanggan ?></div>
            </div>
            <div class="col">
                <div><strong>Nama Instansi : </strong><?= $model->instansi ?></div>
            </div>
            <div class="col">
                <div><strong>Terkahir Pesan : </strong><?= $model->pesenan_terakhir ?></div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <h5>Data Produk</h5>
                <div class="produk-grid">

                    <?= GridView::widget([
                        'dataProvider' => new \yii\data\ArrayDataProvider([
                            'allModels' => $produk,
                            'pagination' => false, // tidak perlu pagination
                        ]),
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'header' => 'No'],

                            [
                                'attribute' => 'kode_barang',
                                'label' => 'Kode Barang',
                                'value' => 'kode_barang',
                            ],
                            [
                                'attribute' => 'nama_barang_custom',
                                'label' => 'Nama Barang',
                                'value' => 'nama_barang_custom',
                            ],
                            [
                                'label' => 'Aksi',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return
                                        '<button class="btn btn-sm btn-primary expand-row" 
                                            data-id="' . $model['produk_custom_pelanggan_id'] . '">
                                            <span class="arrow-icon">▶</span> Detail
                                        </button>';
                                },
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
            <?= Html::a('Create Produk', ['produk-custom-pelanggan/create', 'pelanggan_id' => $model->pelanggan_id], ['class' => 'btn btn-success']) ?>
            <?= Html::a('Update Semua Produk', ['produk-custom-pelanggan/update', 'pelanggan_id' => $model->pelanggan_id], ['class' => 'btn btn-warning']) ?>
            <?= Html::a('Back', 'index', ['class' => 'btn btn-secondary']) ?>
        </div>
    </div>
</div>
<?php
$detailUrl = Url::to(['master-pelanggan/detail-ajax']);
$js = <<<JS
$(document).on('click', '.expand-row', function() {
    var btn = $(this);
    var id = btn.data('id');
    var tr = btn.closest('tr');
    var colspan = tr.children('td').length;

    // Putar ikon panah
    btn.find('.arrow-icon').toggleClass('rotated');

    // Jika baris detail sudah ada, toggle dengan animasi
    if (tr.next().hasClass('detail-row')) {
        var detailRow = tr.next();
        if (detailRow.is(':visible')) {
            detailRow.find('td').slideUp(300, function() {
                detailRow.hide();
            });
        } else {
            detailRow.show();
            detailRow.find('td').hide().slideDown(300);
        }
        return;
    }

    // Tambah placeholder baris detail dengan efek awal yang halus
    var detailRow = $('<tr class="detail-row" style="display:none;"><td colspan="'+colspan+'" class="p-3 text-center bg-light">Loading...</td></tr>');
    tr.after(detailRow);
    detailRow.fadeIn(250);

    // Ambil data via AJAX
    $.ajax({
        url: '{$detailUrl}',
        data: { produk_custom_pelanggan_id: id },
        success: function(res) {
            var td = detailRow.find('td');
            td.fadeOut(150, function() {
                td.html(res).fadeIn(350);
            });
        },
        error: function() {
            detailRow.find('td').fadeOut(150, function() {
                $(this).html('<span class="text-danger">Gagal memuat detail.</span>').fadeIn(350);
            });
        }
    });
});
JS;
$this->registerJs($js);
?>

<style>
    /* Animasi panah */
    .arrow-icon {
        display: inline-block;
        transition: transform 0.3s ease;
    }

    .arrow-icon.rotated {
        transform: rotate(90deg);
    }
</style>