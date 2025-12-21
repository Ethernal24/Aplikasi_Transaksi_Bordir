<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/** @var yii\web\View $this */

$this->title = 'Dashboard';

$url = Url::to(['laporan-agregat/get-aggregated-data']);

$this->registerJsFile('https://code.jquery.com/jquery-3.6.0.min.js', [
    'position' => View::POS_HEAD
]);

$this->registerJsFile('https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js', [
    'position' => View::POS_HEAD
]);
?>

<div class="pc-content">
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-md-6 col-xl-6">
            <div class="card bg-grd-primary order-card">
                <div class="card-body">
                    <h5 class="text-white"><span>Stock Gudang</span></h5>
                    <h6 class="text-start text-white">
                        <span>

                            <?php if (!empty($randomItem['kode_barang']) && !empty($randomItem['nama_barang'])): ?>
                                <?= $randomItem['kode_barang'] ?> - <?= $randomItem['nama_barang'] ?>
                            <?php else: ?>
                                Data barang tidak tersedia
                            <?php endif; ?>

                        </span>
                    </h6>
                    <h2 class="text-end text-white"><i class="fi fi-ts-box-alt float-start g-3"></i>
                        <?= $randomItem['quantity_akhir'] ?? '-' ?>
                    </h2>
                    <!-- <p class="m-b-0">Completed Orders<span class="float-end">351</span></p> -->
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-6">
            <div class="card bg-grd-success order-card">
                <div class="card-body">
                    <h5 class="text-white">Stock Produksi</h5>
                    <h6 class="text-start text-white">
                        <span>
                            <?php if (!empty($randomItemProduksi['kode_barang']) && !empty($randomItemProduksi['nama_barang'])): ?>
                                <?= $randomItem['kode_barang'] ?> - <?= $randomItem['nama_barang'] ?>
                            <?php else: ?>
                                Data barang tidak tersedia
                            <?php endif; ?> </span>
                    </h6>
                    <h2 class="text-end text-white"><i class="fi fi-ts-box-alt float-start g-3"></i>
                        <?= $randomItemProduksi['quantity_akhir'] ?? '-' ?>
                    </h2>
                    <!-- <p class="m-b-0">This Month<span class="float-end">213</span></p> -->
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-7">
            <div class="card">
                <div class="card-header">
                    <h5>Wilayah yang pernah Order di Diwarna</h5>
                </div>
                <div class="card-body">
                    <div id="map" class="set-map" style="height:365px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-5">
            <div class="card">
                <div class="card-header">
                    <h5>Recent Order</h5>
                </div>
                <div class="card-body">
                    <?= GridView::widget([
                        'dataProvider' => new \yii\data\ArrayDataProvider([
                            'allModels' => $pesanDetails,
                            'pagination' => false,
                        ]),
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'header' => 'No'],
                            [
                                'attribute' => 'kode_barang',
                                'label' => 'Kode Barang',
                                'value' => function ($model) {
                                    if ($model->barang) {
                                        return $model->barang->kode_barang;
                                    }
                                    return 'Barang tidak ditemukan';
                                },
                            ],
                            [
                                'attribute' => 'barang_id',
                                'label' => 'Nama Barang',
                                'value' => function ($model) {
                                    if ($model->barang) {
                                        return $model->barang->nama_barang;
                                    }
                                    return 'Barang tidak ditemukan';
                                },
                            ],
                            [
                                'attribute' => 'qty',
                                'label' => 'Quantity Pesan',
                            ],
                            [
                                'attribute' => 'created_at',
                                'format' => 'datetime',
                                'label' => 'Dibuat Pada',
                            ],
                        ],
                    ]); ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php
$script = <<<JS

// Inisialisasi peta dan atur pusatnya di Indonesia
var map = L.map('map').setView([-2.548926, 118.0148634], 5); // Koordinat pusat Indonesia

// Tambahkan layer peta dari OpenStreetMap
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

// Contoh marker: Jakarta
L.marker([-6.2088, 106.8456]).addTo(map) // Koordinat Jakarta
    .bindPopup('Jakarta, Indonesia')
    .openPopup();

// Tambahkan marker lain di lokasi-lokasi di Indonesia
var locations = [
    { title: "Yogyakarta", position: [-7.797068, 110.370529] },
    { title: "Manado", position: [1.48218, 124.84899] },
    { title: "Kabupaten fak fak", position: [-2.9681789118086446, 132.8682517109166] },
    { title: "Kecamatan Wori", position: [1.6313313945801442, 124.90209507802184] },
    { title: "Kabupaten Bangka", position: [-1.917286312945985, 105.9030137753801] },
    { title: "Probolinggo", position: [-7.768922256456851, 113.19638092855286] },
    { title: "Kabupaten Bangkalan", position: [-7.025535325036352, 112.75108682501377] },
    { title: "Kecamatan Batumarmar", position: [-6.953545934028033, 113.49277917391947] },
];

// Loop untuk menambahkan marker pada setiap lokasi
locations.forEach(function (location) {
    L.marker(location.position).addTo(map)
        .bindPopup(location.title);
});

$(document).ready(function() {
    $('#debugInfo').html('Loading data...');
    
    $.ajax({
        url: '{$url}',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            $('#debugInfo').html('Data received. Processing...');
            console.log('Data received:', response);
            
            if (!response || response.length === 0) {
                $('#debugInfo').html('No data received from server');
                return;
            }

           
            const chartData = {
                labels: response.map(item => item.year.toString()),
                datasets: [{
                    label: 'Total Produksi',
                    data: response.map(item => parseInt(item.total_kuantitas)),
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            };

            const config = {
                type: 'line',
                data: chartData,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Grafik Produksi per Tahun'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Total Kuantitas'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Tahun'
                            }
                        }
                    }
                }
            };

            
            const ctx = document.getElementById('productionChart').getContext('2d');
            new Chart(ctx, config);
            
            $('#debugInfo').html('Chart created successfully');
        },
        error: function(xhr, status, error) {
            $('#debugInfo').html('Error loading data: ' + error);
            console.error('Error:', error);
            console.log('Status:', status);
            console.log('Response:', xhr.responseText);
        }
    });
});
JS;

$url = Url::to(['laporan-agregat/get-aggregated-data']);
$this->registerJs($script, View::POS_END);
?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const cells = document.querySelectorAll('td, th');
        cells.forEach(cell => {
            if (cell.textContent.trim() === '(not set)') {
                cell.textContent = 'kosong';
            }
        });
    });
</script>