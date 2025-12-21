<?php

namespace app\controllers;


use Yii;

use app\models\Shift;
use app\models\ShiftSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\db\IntegrityException;
use yii\filters\VerbFilter;

/**
 * ShiftController implements the CRUD actions for Shift model.
 */
class ShiftController extends BaseController
{
    /**s
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
                'access' => [
                    'class' => \yii\filters\AccessControl::class,
                    'only' => ['delete', 'update', 'create', 'index', 'view'], // Aksi yang diatur
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'], // Hanya pengguna yang sudah login
                        ],
                    ],
                ]
            ]
        );
    }

    /**
     * Lists all Shift models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ShiftSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Shift model.
     * @param int $shift_id Shift ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($shift_id)
    {
        $model = $this->findModel($shift_id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Shift model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Shift();

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
     * Updates an existing Shift model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $shift_id Shift ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($shift_id)
    {
        $model = $this->findModel($shift_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }



    /**
     * Deletes an existing Shift model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $shift_id Shift ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($shift_id)
    {
        $this->findModel($shift_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Shift model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $shift_id Shift ID
     * @return Shift the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($shift_id)
    {
        if (($model = Shift::findOne(['shift_id' => $shift_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
