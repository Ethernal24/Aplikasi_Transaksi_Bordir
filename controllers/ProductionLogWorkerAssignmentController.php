<?php

namespace app\controllers;

use app\models\ProductionLogWorkerAssignment;
use app\models\ProductionLogWorkerAssignmentSearch;
use app\models\TenagaKerja;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * ProductionLogWorkerAssignmentController implements the CRUD actions for ProductionLogWorkerAssignment model.
 */
class ProductionLogWorkerAssignmentController extends Controller
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
     * Lists all ProductionLogWorkerAssignment models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProductionLogWorkerAssignmentSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductionLogWorkerAssignment model.
     * @param int $id_assignment Id Assignment
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_assignment)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_assignment),
        ]);
    }

    /**
     * Creates a new ProductionLogWorkerAssignment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new ProductionLogWorkerAssignment();

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
     * Updates an existing ProductionLogWorkerAssignment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_assignment Id Assignment
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_assignment)
    {
        $model = $this->findModel($id_assignment);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ProductionLogWorkerAssignment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_assignment Id Assignment
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_assignment)
    {
        $this->findModel($id_assignment)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProductionLogWorkerAssignment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_assignment Id Assignment
     * @return ProductionLogWorkerAssignment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_assignment)
    {
        if (($model = ProductionLogWorkerAssignment::findOne(['id_assignment' => $id_assignment])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionJadwalKaryawan()
    {
        return $this->render('jadwal_karyawan');
    }

    public function actionDataJadwal()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $employees = TenagaKerja::find()->all();
        $assignments = ProductionLogWorkerAssignment::find()
            ->with(['workOrder', 'shift'])
            ->all();

        $data = [];

        foreach ($employees as $emp) {
            $data[] = [
                "id" => "emp_" . $emp->tk_id,
                "text" => strtoupper($emp->nama),
                "type" => "project",
                "open" => true,
                "color" => "#34495e"
            ];
        }

        foreach ($assignments as $assign) {
            $color = "#3498db";
            if ($assign->id_shift == 1) $color = "#f1c40f";
            elseif ($assign->id_shift == 2) $color = "#e67e22";
            elseif ($assign->id_shift == 3) $color = "#2c3e50";

            $data[] = [
                "id" => $assign->id_assignment,
                "text" => ($assign->shift ? $assign->shift->nama_shift : "S" . $assign->id_shift) .
                    " | " . ($assign->workOrder->kode_wo ?? '-'),
                "start_date" => date('Y-m-d', strtotime($assign->tanggal_assignment)),
                "duration" => 1,
                "parent" => "emp_" . $assign->id_tk,
                "color" => $color,
                "textColor" => ($assign->id_shift == 1) ? "#000" : "#fff",
            ];
        }

        return ['data' => $data];
    }
}
