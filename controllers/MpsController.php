<?php

namespace app\controllers;

use app\helpers\ModelHelper;
use app\models\Bom;
use app\models\BomCustom;
use app\models\MasterMrp;
use app\models\Mps;
use app\models\MpsDetail;
use app\models\MpsSearch;
use app\models\MrpDetail;
use Yii;
use yii\base\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * MpsController implements the CRUD actions for Mps model.
 */
class MpsController extends Controller
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
     * Lists all Mps models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MpsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Mps model.
     * @param int $mps_id Mps ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($mps_id)
    {
        $detail = MpsDetail::find()
            ->where(['mps_id' => $mps_id])
            ->all();

        $model = $this->findModel($mps_id);
        return $this->render('view', [
            'model' => $model,
            'detail' => $detail
        ]);
    }

    /**
     * Creates a new Mps model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Mps();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'mps_id' => $model->mps_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Mps model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $mps_id Mps ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($mps_id)
    {
        $last = MasterMrp::find()
            ->select('kode_mrp')
            ->orderBy(['mrp_id' => SORT_DESC])
            ->one();
        if ($last) {
            $lastnumber = (int) str_replace('MRP-', '', $last->kode_mrp);
            $nextNumber = $lastnumber + 1;
        } else {
            $nextNumber = 1;
        }
        $model = $this->findModel($mps_id);
        $details = $model->mpsDetails;
        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
            $oldIDs = ArrayHelper::map($details, 'mps_detail_id', 'mps_detail_id');
            $details = ModelHelper::createMultiple(MpsDetail::class, $details);
            Model::loadMultiple($details, Yii::$app->request->post());
            $deleteIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($details, 'mps_detail_id', 'mps_detail_id')));
            $valid = $model->validate();
            $valid = Model::validateMultiple($details) && $valid;
            if (!$valid) {
                Yii::error("Validasi gagal MPS: " . json_encode($model->getErrors()), __METHOD__);
                foreach ($details as $d) {
                    Yii::error("Validasi gagal Detail: " . json_encode($d->getErrors()), __METHOD__);
                }
            }
            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $isApproved = $model->status_mps == 1;
                    if ($model->save(false)) {
                        if (!empty($deleteIDs)) {
                            MpsDetail::deleteAll(['mps_detail_id' => $deleteIDs]);
                        }
                        foreach ($details as $detail) {
                            $detail->mps_id = $model->mps_id;
                            $detail->save(false);
                        }
                        if ($isApproved) {
                            $existingMrp = MasterMrp::find()->where(['mps_id' => $model->mps_id])->one();
                            if (!$existingMrp) {
                                $mrp = new MasterMrp();
                                $mrp->mps_id = $model->mps_id;
                                $mrp->kode_mrp = 'MRP' . '' . str_pad($nextNumber, 3, 0, STR_PAD_LEFT);
                                $mrp->status = 0;
                                $mrp->save(false);
                                foreach ($details as $detail) {
                                    $d = new MrpDetail;
                                    $d->minggu_ke = $detail->minggu_ke;
                                    $d->mrp_id = $mrp->mrp_id;
                                    $d->barang_id = $model->barang->barang_id;
                                    $d->kebutuhan_kotor = $detail->rencana_produksi;
                                    $d->stock_tersedia = $model->barang->stok;
                                    $d->kebutuhan_bersih = $d->kebutuhan_kotor - $d->stock_tersedia;
                                    $d->leadtime = $model->barang->leadtime;
                                    $d->planned_order_receipt = 0;
                                    $d->planned_order_release = 0;
                                    $d->save(false);
                                    if ($model->tipe == 0) {
                                        // MTS → ambil dari tabel BOM tetap
                                        $boms = Bom::find()->where(['produk_id' => $model->barang_id])->all();
                                    } else {
                                        // MTO → ambil dari BOM custom pelanggan
                                        $boms = BomCustom::find()->where(['produk_custom_pelanggan_id' => $model->barang_id])->all();
                                    }
                                    foreach ($boms as $bom) {
                                        $b = new MrpDetail;
                                        $b->mrp_id = $mrp->mrp_id;
                                        $b->minggu_ke = $detail->minggu_ke;
                                        $b->barang_id = $bom->bahan->barang_id;
                                        $b->kebutuhan_kotor = $bom->qty_per_unit * $detail->rencana_produksi;
                                        $b->stock_tersedia = $bom->bahan->stok;
                                        $b->kebutuhan_bersih = $b->kebutuhan_kotor - $b->stock_tersedia;
                                        $b->leadtime = $bom->bahan->leadtime;
                                        $b->planned_order_receipt = 0;
                                        $b->planned_order_release = 0;
                                        $b->save(false);
                                    }
                                }
                            }
                        }
                    }
                    $transaction->commit();
                    return $this->redirect(['view', 'mps_id' => $model->mps_id]);
                } catch (\Exception $e) {
                    Yii::error("Terjadi Kesalahan : " . $e->getMessage(), __METHOD__);
                    $transaction->rollBack();
                    throw $e;
                }
            }
        }
        return $this->render('update', [
            'model' => $model,
            'details' => $details
        ]);
    }

    /**
     * Deletes an existing Mps model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $mps_id Mps ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($mps_id)
    {
        $this->findModel($mps_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Mps model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $mps_id Mps ID
     * @return Mps the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($mps_id)
    {
        if (($model = Mps::findOne(['mps_id' => $mps_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
