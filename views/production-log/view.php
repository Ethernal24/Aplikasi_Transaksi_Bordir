<?php

use yii\bootstrap5\Modal;
use yii\bootstrap5\Tabs;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\ProductionLog $model */

$this->title = 'Detail Log  ';
$this->params['breadcrumbs'][] = ['label' => 'Production Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pc-content">
    <div class="card table-card">
        <div class="card-header">
            <h1><?= Html::encode($this->title) ?></h1>
            <div class="row">
                <div class="col-md-4">
                    <span>
                        <strong>
                            Kode Log :
                        </strong>
                        <?= $model->kode_log ?>
                    </span>
                </div>
                <div class="col-md-4">
                    <span>
                        <strong>
                            Tanggal :
                        </strong>
                        <?= $model->tanggal ?>
                    </span>
                </div>
                <div class="col-md-4">
                    <span>
                        <strong>
                            Status :
                        </strong>
                       <span class="<?= $model->getLabelStatus()['class'] ?>"><?= $model->getLabelStatus()['label']  ?>
                       </span> 
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <span>
                        <strong>
                            Kode WO :
                        </strong>
                        <?= $model->wo->kode_wo ?>
                    </span>
                </div>
                <div class="col-md-4">
                    <span>
                        <strong>
                            Work Center :
                        </strong>
                        <?= $model->workcenter->nama_workcenter ?>
                    </span>
                </div>
                <div class="col-md-4">
                    <span>
                        <strong>
                            Shift :
                        </strong>
                        <?= $model->shift->nama_shift ?>
                    </span>
                </div>
            </div>
        </div>
        <hr>
        <div class="card-body mx-4">
            <?= Tabs::widget([
                'items' => [
                    [
                        'label' => '<i class="fa fa-info-circle"></i> Activity (Aktivitas)',
                        'encode' => false,
                        'content' => $this->render('_tab_activity', [
                            'model' => $model,
                            'activityProvider' => $activityProvider,
                        ]),
                        'active' => true,
                    ],
                    [
                        'label' => '<i class="fa fa-box"></i> Detail',
                        'content' => $this->render('_tab_detail', [
                            'model' => $model,
                            'detailProvider' => $detailProvider,
                        ]),
                        'encode' => false,
                    ],
                    [
                        'label' => '<i class="fa fa-tasks"></i> Downtime (Kendala)',
                        'content' => $this->render('_tab_downtime', [
                            'model' => $model,
                            'downtimeProvider' => $downtimeProvider,
                        ]),
                        'encode' => false,
                    ],
                    [
                        'label' => '<i class="fa fa-tasks"></i> Attendance (lama kerja) ',
                        'content' => $this->render('_tab_attendance', [
                            'model' => $model,
                            'attendanceProvider' => $attendanceProvider,
                        ]),
                        'encode' => false,
                    ],
                    // [
                    //     'label' => '<i class="fa fa-tasks"></i> Pekerja',
                    //     'encode' => false,
                    // ],
                ]
            ]) ?>

        </div>
        <hr>
        <div class="card-footer">
            <!-- <?= Html::a('Update', ['update', 'id_log' => $model->id_log], ['class' => 'btn btn-primary']) ?> -->
            <?= Html::a('Back', ['index'], ['class' => 'btn btn-secondary']) ?>
        </div>
    </div>
</div>
<?php

Modal::begin([
    'title' => '<h4 id="modalTitle">Form Produksi</h4>',
    'id' => 'modal-universal', // ID satu untuk semua
    'size' => 'modal-lg',
]);
echo "<div id='modalContent'><div class='text-center'><i class='fas fa-spinner fa-spin'></i> Loading...</div></div>";
Modal::end();
?>