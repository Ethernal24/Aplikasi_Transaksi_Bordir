<?php
// Di dalam ProductionController.php
namespace app\controllers; // Pastikan baris ini ada dan benar

use app\models\RoutingDetail;
use Yii;
use app\models\Workcenter;
use app\models\WorkOrderSearch;
use yii\base\Controller;

class LaporanController extends Controller
{
    public function actionLaporanWip()
    {
        // 1. Ambil semua Workcenter untuk dijadikan Header Kolom
        $workcenters = Workcenter::find()
            ->joinWith('routingDetails')
            ->orderBy(['urutan' => SORT_ASC])
            ->all();

        // 2. Gunakan SearchModel atau ActiveDataProvider untuk list WO yang masih aktif
        $searchModel = new WorkOrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // Filter agar hanya menampilkan WO yang belum 'Closed' atau 'Finished'
        $dataProvider->query->andWhere(['!=', 'status_wo', [3, 4]]);

        return $this->render('laporan-wip', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'workcenters' => $workcenters,
        ]);
    }
}
