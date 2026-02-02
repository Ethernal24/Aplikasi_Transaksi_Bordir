<?php

namespace app\controllers;

use app\models\JadwalSimulasi;
use app\models\JadwalSimulasiSearch;
use app\models\Workorder;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * JadwalSimulasiController implements the CRUD actions for JadwalSimulasi model.
 */
class JadwalSimulasiController extends Controller
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
     * Lists all JadwalSimulasi models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new JadwalSimulasiSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single JadwalSimulasi model.
     * @param int $simulasi_id Simulasi ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($simulasi_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($simulasi_id),
        ]);
    }

    /**
     * Creates a new JadwalSimulasi model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new JadwalSimulasi();
        $workorders = Workorder::find()
            ->select(['tanggal_wo', 'due_date'])
            ->where(['not in', 'status_wo', [3, 4]])
            ->asArray()
            ->all(); // Hasilnya: ['2026-02-10', '2026-02-15']

        $disabledDates = [];
        foreach ($workorders as $wo) {
            $start = new \DateTime($wo['tanggal_wo']);
            $end = new \DateTime($wo['due_date']);
            $end->modify('+1 day'); // Agar hari terakhir juga masuk hitungan

            $interval = new \DateInterval('P1D');
            $period = new \DatePeriod($start, $interval, $end);

            foreach ($period as $date) {
                $disabledDates[] = $date->format("Y-m-d");
            }
        }
        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'simulasi_id' => $model->simulasi_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'disabledDates' => $disabledDates
        ]);
    }

    /**
     * Updates an existing JadwalSimulasi model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $simulasi_id Simulasi ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($simulasi_id)
    {
        $model = $this->findModel($simulasi_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'simulasi_id' => $model->simulasi_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing JadwalSimulasi model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $simulasi_id Simulasi ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($simulasi_id)
    {
        $this->findModel($simulasi_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the JadwalSimulasi model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $simulasi_id Simulasi ID
     * @return JadwalSimulasi the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($simulasi_id)
    {
        if (($model = JadwalSimulasi::findOne(['simulasi_id' => $simulasi_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
