<?php

namespace app\controllers;

use app\models\MasterRouting;
use app\models\MasterRoutingSearch;
use app\models\RoutingDetail;
use yii\base\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\helpers\ModelHelper;
use app\models\Mesin;
use app\models\Shift;
use app\models\TenagaKerja;
use app\models\Workcenter;
use Yii;
use yii\web\Response;
use yii\helpers\ArrayHelper;

/**
 * MasterRoutingController implements the CRUD actions for MasterRouting model.
 */
class MasterRoutingController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all MasterRouting models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MasterRoutingSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MasterRouting model.
     * @param int $routing_id Routing ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($routing_id)
    {
        $model = $this->findModel($routing_id);
        $detail = $model->details;
        if (empty($detail)) {
            Yii::info('Data Detail tidak tersedia');
        }

        return $this->render('view', [
            'model' => $model,
            'detail' => $detail
        ]);
    }

    /**
     * Creates a new MasterRouting model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new MasterRouting();
        $modelDetails = [new RoutingDetail()];

        $model->kode_routing = $model->generateAutoNumber('KK-R', 'kode_routing');


        if ($model->load($this->request->post())) {
            $modelDetails = ModelHelper::createMultiple(RoutingDetail::class);
            Model::loadMultiple($modelDetails, $this->request->post());
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelDetails) && $valid;
            if (!$valid) {
                foreach ($modelDetails as $dIndex => $detail) {
                    if ($detail->errors) {
                        Yii::error(
                            ["index" => $dIndex, "errors" => $detail->errors],
                            'RoutingDetailErrors'
                        );
                    }
                }
            }
            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($model->save(false)) {
                        foreach ($modelDetails as $detail) {
                            $detail->routing_id = $model->routing_id;
                            if (! $detail->save(false)) {
                                Yii::error($detail->errors, 'RoutingDetailSaveError');
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    $transaction->commit();
                    return $this->redirect(['view', 'routing_id' => $model->routing_id]);
                } catch (\Exception $e) {
                    Yii::error($e->getMessage(), 'CreateRoutingException');
                    $transaction->rollBack();
                    throw $e;
                }
            }
        }
        return $this->render('create', [
            'model' => $model,
            'modelDetails' => $modelDetails,
        ]);
    }

    /**
     * Updates an existing MasterRouting model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $routing_id Routing ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($routing_id)
    {
        $model = $this->findModel($routing_id);
        // 1. Ambil data lama
        $modelDetails = $model->details;

        if ($model->load(Yii::$app->request->post())) {

            $oldIDs = ArrayHelper::map($modelDetails, 'routing_detail_id', 'routing_detail_id');

            // 2. KUNCI PERBAIKAN: Pastikan parameter kedua ($modelDetails) dikirimkan
            // agar ModelHelper mencocokkan ID dari POST dengan objek yang sudah ada.
            $modelDetails = ModelHelper::createMultiple(RoutingDetail::class, $modelDetails, 'routing_detail_id');

            Model::loadMultiple($modelDetails, Yii::$app->request->post());

            $currIDs = ArrayHelper::map($modelDetails, 'routing_detail_id', 'routing_detail_id');
            $deletedIDs = array_diff($oldIDs, $currIDs);

            $valid = $model->validate();
            $valid = Model::validateMultiple($modelDetails) && $valid;

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($model->save(false)) {
                        // Hapus yang dibuang di form
                        if (!empty($deletedIDs)) {
                            RoutingDetail::deleteAll(['routing_detail_id' => $deletedIDs]);
                        }

                        foreach ($modelDetails as $detail) {
                            $detail->routing_id = $model->routing_id;
                            // Yii akan otomatis menjalankan UPDATE jika $detail->isNewRecord adalah false
                            if (!($detail->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    $transaction->commit();
                    return $this->redirect(['view', 'routing_id' => $model->routing_id]);
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'modelDetails' => (empty($modelDetails)) ? [new RoutingDetail()] : $modelDetails
        ]);
    }

    /**
     * Deletes an existing MasterRouting model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $routing_id Routing ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($routing_id)
    {
        $this->findModel($routing_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MasterRouting model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $routing_id Routing ID
     * @return MasterRouting the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($routing_id)
    {
        if (($model = MasterRouting::findOne(['routing_id' => $routing_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGetOutputKapasitas($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $workcenter = Workcenter::findOne($id);
        if (!$workcenter) return ['success' => false];
        $isMesin = in_array($workcenter->tipe_kapasitas, [0, 2]);
        $mesin = Mesin::find()->where(['workcenter_id' => $id])->one();
        $shift = Shift::find()->one(); // Sebaiknya tambahkan ->where(['is_active' => 1])

        if ($isMesin && $mesin && $shift && $shift->jam_efektif > 0) {
            $outputHari = $mesin->max_kapasitas_operasi_hari;
            $outputJam = $outputHari / $shift->jam_efektif;
            $WaktuStd = 60 / $outputJam;

            return [
                'success' => true,
                'is_mesin' => true, // Flag untuk JavaScript
                'output_jam' => $outputJam,
                'WaktuStd' => $WaktuStd,
            ];
        }

        return [
            'success' => true, // Tetap true agar JavaScript bisa memproses kondisi "bukan mesin"
            'is_mesin' => false,
            'output_jam' => 0,
            'WaktuStd' => 0,
        ];
    }
}
