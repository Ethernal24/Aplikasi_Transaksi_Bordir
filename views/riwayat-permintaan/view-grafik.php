<?php

use yii\helpers\Url;
use yii\helpers\Html;
use app\models\Barang;
?>



<div style="width:100%; max-width:900px; margin:0 auto;">
    <canvas id="permintaanChart" height="150"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script>
    const labels = <?= $labels ?>;
    const values = <?= $values ?>;

    new Chart(document.getElementById('permintaanChart'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Permintaan',
                data: values,
                borderColor: 'rgba(54,162,235,1)',
                backgroundColor: 'rgba(54,162,235,0.2)',
                tension: 0.3,
                fill: true,
                pointRadius: 3
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                },
            },
            scales: {
                y: {
                    title: {
                        display: true,
                        text: 'Jumlah Permintaan'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Periode (Tahun-Bulan)'
                    }
                }
            }
        }
    });
</script>