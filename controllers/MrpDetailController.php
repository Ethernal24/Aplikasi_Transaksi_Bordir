<?php

namespace app\controllers;

use app\models\MrpDetail;
use app\models\MrpDetailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MrpDetailController implements the CRUD actions for MrpDetail model.
 */
class MrpDetailController extends Controller
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
     * Lists all MrpDetail models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MrpDetailSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MrpDetail model.
     * @param int $mrp_detail_id Mrp Detail ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($mrp_detail_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($mrp_detail_id),
        ]);
    }

    /**
     * Creates a new MrpDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new MrpDetail();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'mrp_detail_id' => $model->mrp_detail_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MrpDetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $mrp_detail_id Mrp Detail ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($mrp_detail_id)
    {
        $model = $this->findModel($mrp_detail_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'mrp_detail_id' => $model->mrp_detail_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MrpDetail model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $mrp_detail_id Mrp Detail ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($mrp_detail_id)
    {
        $this->findModel($mrp_detail_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MrpDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $mrp_detail_id Mrp Detail ID
     * @return MrpDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($mrp_detail_id)
    {
        if (($model = MrpDetail::findOne(['mrp_detail_id' => $mrp_detail_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
