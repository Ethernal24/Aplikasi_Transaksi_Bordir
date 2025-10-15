<?php

namespace app\controllers;

use app\helpers\ModelHelper;
use app\models\BomCustom;
use app\models\BomCustomSearch;
use Yii;
use yii\base\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * BomCustomController implements the CRUD actions for BomCustom model.
 */
class BomCustomController extends Controller
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
     * Lists all BomCustom models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new BomCustomSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BomCustom model.
     * @param int $bom_custom_id Bom Custom ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($bom_custom_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($bom_custom_id),
        ]);
    }

    /**
     * Creates a new BomCustom model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new BomCustom();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'bom_custom_id' => $model->bom_custom_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing BomCustom model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $bom_custom_id Bom Custom ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($bom_custom_id)
    {
        $model = $this->findModel($bom_custom_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'bom_custom_id' => $model->bom_custom_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing BomCustom model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $bom_custom_id Bom Custom ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($bom_custom_id)
    {
        $this->findModel($bom_custom_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the BomCustom model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $bom_custom_id Bom Custom ID
     * @return BomCustom the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($bom_custom_id)
    {
        if (($model = BomCustom::findOne(['bom_custom_id' => $bom_custom_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionUpdateMultiple($permintaan_detail_id)
    {
        Yii::info("=== Mulai updateMultiple untuk permintaan_detail_id: {$permintaan_detail_id} ===", __METHOD__);

        $models = BomCustom::find()
            ->where(['permintaan_detail_id' => $permintaan_detail_id])
            ->all();

        Yii::info("Jumlah model ditemukan: " . count($models), __METHOD__);
        foreach ($models as $index => $m) {
            Yii::info("Model #{$index} -> bom_custom_id: {$m->bom_custom_id}, permintaan_detail_id: {$m->permintaan_detail_id}", __METHOD__);
        }

        if (Yii::$app->request->isPost) {
            Yii::info("Request POST diterima", __METHOD__);

            $oldIDs = ArrayHelper::map($models, 'bom_custom_id', 'bom_custom_id');
            Yii::info("Old IDs: " . json_encode($oldIDs), __METHOD__);

            $models = ModelHelper::createMultiple(BomCustom::class, $models);
            Model::loadMultiple($models, Yii::$app->request->post());
            foreach ($models as $i => $model) {
                if (empty($model->permintaan_detail_id)) {
                    $model->permintaan_detail_id = $permintaan_detail_id;
                    Yii::info("Model #{$i} permintaan_detail_id diisi manual: {$permintaan_detail_id}", __METHOD__);
                }
            }
            $newIDs = ArrayHelper::getColumn($models, 'bom_custom_id');
            $deletedIDs = array_diff($oldIDs, array_filter($newIDs));

            Yii::info("New IDs: " . json_encode($newIDs), __METHOD__);
            Yii::info("Deleted IDs: " . json_encode($deletedIDs), __METHOD__);

            $valid = Model::validateMultiple($models);
            Yii::info("Validation result: " . ($valid ? 'VALID' : 'NOT VALID'), __METHOD__);

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if (!empty($deletedIDs)) {
                        Yii::info("Menghapus BOM dengan ID: " . json_encode($deletedIDs), __METHOD__);
                        BomCustom::deleteAll(['bom_custom_id' => $deletedIDs]);
                    }

                    foreach ($models as $i => $model) {
                        if (empty($model->bahan_id)) {
                            Yii::info("Model #{$i} dilewati karena bahan_id kosong", __METHOD__);
                            continue;
                        }
                        if (empty($model->permintaan_detail_id)) {
                            $model->permintaan_detail_id = $permintaan_detail_id;
                            Yii::info("Model #{$i} permintaan_detail_id diset manual: {$permintaan_detail_id}", __METHOD__);
                        }

                        // CEK apakah model baru
                        if (empty($model->bom_custom_id)) {
                            $model->isNewRecord = true;
                        }

                        $model->save(false);
                        Yii::info("Model #{$i} disimpan (bom_custom_id: {$model->bom_custom_id})", __METHOD__);
                    }

                    $transaction->commit();
                    Yii::info("Transaksi commit berhasil", __METHOD__);
                    Yii::$app->session->setFlash('success', 'Data BOM berhasil diperbarui.');

                    // Debug relasi untuk memastikan tidak null
                    $permintaan_id = $models[0]->detail->permintaan_id ?? null;
                    if ($permintaan_id === null) {
                        Yii::warning("Relasi detail->permintaan_id NULL untuk bom_custom_id: " . ($models[0]->bom_custom_id ?? 'unknown'), __METHOD__);
                    } else {
                        Yii::info("Redirect ke permintaan_id: {$permintaan_id}", __METHOD__);
                    }

                    return $this->redirect(['permintaan-pelanggan/view', 'permintaan_id' => $permintaan_id]);
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    Yii::error("Gagal menyimpan BOM: " . $e->getMessage(), __METHOD__);
                    throw $e;
                }
            } else {
                Yii::warning("Validasi gagal pada beberapa model", __METHOD__);
            }
        }

        Yii::info("Render form update-multiple", __METHOD__);

        return $this->render('update-multiple', [
            'models' => $models,
        ]);
    }
}
