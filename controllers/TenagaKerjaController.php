<?php

namespace app\controllers;

use app\helpers\ModelHelper;
use app\models\TenagaKerja;
use app\models\TenagaKerjaSearch;
use Yii;
use yii\base\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TenagaKerjaController implements the CRUD actions for TenagaKerja model.
 */
class TenagaKerjaController extends Controller
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
     * Lists all TenagaKerja models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TenagaKerjaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TenagaKerja model.
     * @param int $tk_id Tk ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($tk_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($tk_id),
        ]);
    }

    /**
     * Creates a new TenagaKerja model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $modelTenagas = [new TenagaKerja()];

        if (Yii::$app->request->isPost) {
            $modelTenagas = ModelHelper::createMultiple(TenagaKerja::className());
            if (Model::loadMultiple($modelTenagas, Yii::$app->request->post())) {
                foreach ($modelTenagas as $index => $modelTenaga) {
                    Yii::info("Loaded ModelTenaga #$index: " . json_encode($modelTenaga->attributes), 'modelData');
                }
            } else {
                Yii::info("Data failed to load into modelTenagas.", 'loadError');
            }

            if (Model::validateMultiple($modelTenagas)) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    foreach ($modelTenagas as $index => $modelTenaga) {
                        $modelTenaga->dibuat_pada = date('Y-m-d H:i:s');
                        $modelTenaga->diupdate_pada = date('Y-m-d H:i:s');

                        if (!$modelTenaga->save(false)) {
                            throw new \yii\db\Exception("Gagal menyimpan item #{$index}");
                        }
                    }

                    $transaction->commit();
                    Yii::$app->session->setFlash('success', 'Data berhasil disimpan.');

                    return $this->redirect(['index']);
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', 'Error: ' . $e->getMessage());
                }
            } else {
                $allErrors = [];
                foreach ($modelTenagas as $index => $modelTenaga) {
                    if (!empty($modelTenaga->getErrors())) {
                        $allErrors[] = "Item #{$index} errors: " . json_encode($modelTenaga->getErrors());
                    }
                }
                Yii::$app->session->setFlash('error', 'Validation failed: ' . implode(' | ', $allErrors));
            }
        }

        return $this->render('create', [
            'modelTenagas' => $modelTenagas,
        ]);
    }


    /**
     * Updates an existing TenagaKerja model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $tk_id Tk ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($tk_id)
    {
        $model = $this->findModel($tk_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'tk_id' => $model->tk_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TenagaKerja model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $tk_id Tk ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($tk_id)
    {
        $this->findModel($tk_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TenagaKerja model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $tk_id Tk ID
     * @return TenagaKerja the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($tk_id)
    {
        if (($model = TenagaKerja::findOne(['tk_id' => $tk_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
