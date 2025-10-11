<?php

namespace app\controllers;

use app\helpers\ModelHelper;
use app\models\Bom;
use app\models\BomSearch;
use Yii;
use yii\base\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BomController implements the CRUD actions for Bom model.
 */
class BomController extends Controller
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
     * Lists all Bom models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new BomSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Bom model.
     * @param int $bom_id Bom ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($bom_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($bom_id),
        ]);
    }

    /**
     * Creates a new Bom model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $modelBoms = [new Bom()];

        if (Yii::$app->request->isPost) {
            $modelBoms = ModelHelper::createMultiple(Bom::className());
            Model::loadMultiple($modelBoms, Yii::$app->request->post());

            if (Model::validateMultiple($modelBoms)) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    foreach ($modelBoms as $index => $modelBom) {
                        if (!$modelBom->save(false)) {
                            throw new \yii\db\Exception("Gagal menyimpan BOM #{$index}");
                        }
                    }
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', 'Data BOM berhasil disimpan.');
                    return $this->redirect(['/barang/index-barang-jadi']);
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', 'Error: ' . $e->getMessage());
                }
            } else {
                $allErrors = [];
                foreach ($modelBoms as $index => $modelBom) {
                    if ($modelBom->getErrors()) {
                        $allErrors[] = "Item #{$index}: " . json_encode($modelBom->getErrors());
                    }
                }
                Yii::$app->session->setFlash('error', 'Validasi gagal: ' . implode(' | ', $allErrors));
            }
        }

        return $this->render('create', [
            'modelBoms' => $modelBoms,
        ]);
    }

    /**
     * Updates an existing Bom model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $bom_id Bom ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($bom_id)
    {
        $model = $this->findModel($bom_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'bom_id' => $model->bom_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Bom model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $bom_id Bom ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($bom_id)
    {
        $this->findModel($bom_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Bom model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $bom_id Bom ID
     * @return Bom the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($bom_id)
    {
        if (($model = Bom::findOne(['bom_id' => $bom_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
