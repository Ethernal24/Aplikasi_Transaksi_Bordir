<?php

use yii\helpers\Html;

$this->registerCssFile("https://cdn.dhtmlx.com/gantt/edge/dhtmlxgantt.css");
$this->registerJsFile("https://cdn.dhtmlx.com/gantt/edge/dhtmlxgantt.js");

// Tambahkan CSS untuk Legend dan Grid
$this->registerCss("
    .gantt_grid_head_cell { font-weight: bold; }
    .gantt-legend { padding: 15px; background: #f8f9fa; border-top: 1px solid #dee2e6; display: flex; gap: 20px; }
    .legend-item { display: flex; align-items: center; gap: 8px; font-size: 13px; }
    .legend-color { width: 20px; height: 10px; border-radius: 2px; }
");
?>

<div class="pc-content">
    <div class="card table-card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3 class="card-title text-white mb-0">Gantt Chart Jadwal Shift Karyawan</h3>
            <div class="btn-group shadow-sm">
                <button class="btn btn-light btn-sm" onclick="gantt.ext.zoom.setLevel('minggu')">
                    <i class="fas fa-search-plus"></i> Zoom In (Minggu)
                </button>
                <button class="btn btn-light btn-sm" onclick="gantt.ext.zoom.setLevel('bulan')">
                    <i class="fas fa-search-minus"></i> Zoom Out (Bulan)
                </button>
            </div>
        </div>

        <div class="card-body p-0">
            <div id="gantt_here" style='width:100%; height:600px;'></div>

            <div class="gantt-legend">
                <div class="legend-item">
                    <div class="legend-color" style="background: #34495e;"></div> Karyawan
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background: #f1c40f;"></div> Shift 1 (Pagi)
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background: #e67e22;"></div> Shift 2 (Siang)
                </div>
            </div>
        </div>

        <div class="card-footer">
            <?= Html::a('<i class="fas fa-arrow-left"></i> Back', ['index'], ['class' => 'btn btn-secondary']) ?>
        </div>
    </div>
</div>

<?php
$script = <<< JS
    // 1. Konfigurasi Zoom
    var zoomConfig = {
        levels: [
            {
                name: "minggu",
                scale_height: 50,
                min_column_width: 60,
                scales: [
                    {unit: "month", step: 1, format: "%F %Y"},
                    {unit: "day", step: 1, format: "%D, %d"}
                ]
            },
            {
                name: "bulan",
                scale_height: 50,
                min_column_width: 120,
                scales: [
                    {unit: "month", step: 1, format: "%F %Y"},
                    {unit: "week", step: 1, format: "Minggu %W"}
                ]
            }
        ]
    };

    // 2. Terapkan Konfigurasi Global SEBELUM init
    gantt.ext.zoom.init(zoomConfig);
    gantt.ext.zoom.setLevel("minggu"); 

    gantt.config.date_format = "%Y-%m-%d %H:%i";
    gantt.config.work_time = false;      // Menghilangkan pemotongan jam istirahat otomatis
    gantt.config.skip_off_time = false;  // Menampilkan 24 jam penuh
    
    gantt.config.readonly = true; 
    gantt.config.grid_width = 350;
    gantt.config.fit_tasks = true;

    // Tambahan: Pastikan baris tugas (bar) memiliki tinggi yang cukup untuk teks
    gantt.config.row_height = 30;
    gantt.config.bar_height = 22;

    gantt.config.columns = [
        {name: "text", label: "Karyawan / Shift", tree: true, width: "*"},
    ];

    // 4. Inisialisasi
    gantt.init("gantt_here");

    // 5. Event: Auto Scroll ke data pertama
    gantt.attachEvent("onLoadEnd", function(){
        if (gantt.getTaskCount() > 0) {
            var tasks = gantt.getTaskByTime();
            if(tasks && tasks.length > 0) {
                // Gunakan task pertama yang ditemukan secara kronologis
                gantt.showDate(tasks[0].start_date);
            }
        }
    });

    gantt.load("/production-log-worker-assignment/data-jadwal");
JS;
$this->registerJs($script);
?>