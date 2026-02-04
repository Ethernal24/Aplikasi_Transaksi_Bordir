<?php

namespace app\controllers;

use app\models\MasterMrp;
use app\models\MasterMrpSearch;
use app\models\MrpDetail;
use app\models\MrpDetailSearch;
use app\models\WoHeader;
use kartik\mpdf\Pdf;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MasterMrpController implements the CRUD actions for MasterMrp model.
 */
class MasterMrpController extends Controller
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
     * Lists all MasterMrp models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MasterMrpSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MasterMrp model.
     * @param int $mrp_id Mrp ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($mrp_id)
    {
        $searchModel = new MrpDetailSearch();
        $model = $this->findModel($mrp_id);
        $details = $model->mrpDetails;
        return $this->render('view', [
            'model' => $model,
            'details' => $details,
        ]);
    }

    /**
     * Creates a new MasterMrp model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new MasterMrp();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'mrp_id' => $model->mrp_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MasterMrp model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $mrp_id Mrp ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($mrp_id)
    {
        $model = $this->findModel($mrp_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'mrp_id' => $model->mrp_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MasterMrp model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $mrp_id Mrp ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($mrp_id)
    {
        $this->findModel($mrp_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MasterMrp model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $mrp_id Mrp ID
     * @return MasterMrp the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($mrp_id)
    {
        if (($model = MasterMrp::findOne(['mrp_id' => $mrp_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionValidasi($mrp_id)
    {
        $model = $this->findModel($mrp_id);
        if (!$model) {
            Yii::$app->session->setFlash('error', 'Data Mrp tidak ditemukan');
            return $this->redirect(['index']);
        }
        $model->status = 1;
        $model->save();
        return $this->redirect(['index']);
    }
    public function actionDownloadPdf($id)
    {
        // 1. Ambil konten HTML dari view
        $details = MrpDetail::find()->where(['mrp_id' => $id])->all(); 

        // DEBUG: Aktifkan baris di bawah ini untuk cek apakah data ada atau tidak
        // var_dump($details); die();

        $content = $this->renderPartial('_view_report', [
            'details' => $details, // Variabel ini harus sama dengan yang dipanggil di View
        ]);

        // 2. Setup komponen mPDF
        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8, 
            'format' => Pdf::FORMAT_A4, 
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            'destination' => Pdf::DEST_BROWSER, // Langsung buka di browser
            'content' => $content,  
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            'options' => ['title' => 'Laporan MRP'],
            'methods' => [ 
                'SetHeader' => ['CV Diwarna || Dicetak pada: ' . date("r")], 
                'SetFooter' => ['|Halaman {PAGENO}|'],
            ]
        ]);

        return $pdf->render(); 
    }   
}
