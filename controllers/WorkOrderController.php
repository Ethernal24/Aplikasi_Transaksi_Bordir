<?php

namespace app\controllers;

use app\models\PermintaanDetail;
use app\models\PermintaanPelanggan;
use app\models\WorkOrder;
use app\models\WorkOrderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * WorkOrderController implements the CRUD actions for WorkOrder model.
 */
class WorkOrderController extends Controller
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
     * Lists all WorkOrder models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new WorkOrderSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WorkOrder model.
     * @param int $id_wo Id Wo
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_wo)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_wo),
        ]);
    }

    /**
     * Creates a new WorkOrder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new WorkOrder();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['index']);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing WorkOrder model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_wo Id Wo
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_wo)
    {
        $model = $this->findModel($id_wo);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing WorkOrder model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_wo Id Wo
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_wo)
    {
        $this->findModel($id_wo)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the WorkOrder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_wo Id Wo
     * @return WorkOrder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_wo)
    {
        if (($model = WorkOrder::findOne(['id_wo' => $id_wo])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGetBarang($id)
    {
        // 1. Ambil data Header
        $header = PermintaanPelanggan::findOne($id);
        $dueDate = $header ? $header->tenggat_waktu : '';

        // 2. Ambil data Detail
        $details = PermintaanDetail::find()
            ->where(['permintaan_id' => $id])
            ->all();

        $options = "<option value=''>Pilih Barang...</option>";
        $dataKatalog = [];

        // Periksa apakah data ada dan tidak kosong
        if (!empty($details)) {
            foreach ($details as $item) {
                // Gunakan null coalescing atau check relasi agar tidak error jika produk null
                $namaBarang = isset($item->produk) ? $item->produk->nama_barang : "Produk tidak dikenal";

                $options .= "<option value='" . $item->permintaan_detail_id . "'>" . $namaBarang . "</option>";

                $dataKatalog[$item->permintaan_detail_id] = [
                    'qty' => $item->jumlah,
                    'duedate' => $dueDate
                ];
            }
        } else {
            // Jika detail kosong, berikan opsi keterangan kosong
            $options = "<option value=''>- Tidak ada barang untuk permintaan ini -</option>";
        }

        return Json::encode([
            'html' => $options,
            'katalog' => $dataKatalog
        ]);
    }
}
