<?php

namespace app\controllers;

use app\helpers\ModelHelper;
use app\models\BomCustom;
use app\models\MasterPelanggan;
use app\models\ProdukCustomPelanggan;
use app\models\ProdukCustomPelangganSearch;
use Yii;
use yii\base\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

use function PHPUnit\Framework\once;

/**
 * ProdukCustomPelangganController implements the CRUD actions for ProdukCustomPelanggan model.
 */
class ProdukCustomPelangganController extends Controller
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
     * Lists all ProdukCustomPelanggan models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProdukCustomPelangganSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProdukCustomPelanggan model.
     * @param int $produk_custom_pelanggan_id Produk Custom Pelanggan ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($produk_custom_pelanggan_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($produk_custom_pelanggan_id),
        ]);
    }

    /**
     * Creates a new ProdukCustomPelanggan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($pelanggan_id)
    {

        $lastProduk = ProdukCustomPelanggan::find()
            ->where(['pelanggan_id' => $pelanggan_id])
            ->orderBy(['produk_custom_pelanggan_id' => SORT_DESC])
            ->one();

        if ($lastProduk && preg_match('/-(\d+)$/', $lastProduk->kode_barang, $matches)) {
            $lastNumber = (int) $matches[1];
        } else {
            $lastNumber = 1;
        }
        // Ambil data pelanggan berdasarkan ID
        $pelanggan = MasterPelanggan::find()
            ->where(['pelanggan_id' => $pelanggan_id])
            ->one();

        if (!$pelanggan) {
            throw new NotFoundHttpException('Data pelanggan tidak ditemukan.');
        }

        // Inisialisasi model awal
        $model = [new ProdukCustomPelanggan()];
        $modelsBom = [[new BomCustom()]];

        // Jika form disubmit
        if (Yii::$app->request->isPost) {
            $model = ModelHelper::createMultiple(ProdukCustomPelanggan::class);
            Model::loadMultiple($model, Yii::$app->request->post());

            $modelsBom = [];
            if (isset($_POST['BomCustom']) && is_array($_POST['BomCustom'])) {
                foreach ($_POST['BomCustom'] as $i => $boms) {
                    $modelsBom[$i] = ModelHelper::createMultiple(BomCustom::class, $modelsBom[$i] ?? []);
                    Model::loadMultiple($modelsBom[$i], ['BomCustom' => $boms]);
                }
            }
            // ✅ Isi pelanggan_id sebelum validasi
            foreach ($model as $m) {
                $m->pelanggan_id = $pelanggan_id;
            }

            // Validasi semua model
            $valid = Model::validateMultiple($model);
            foreach ($modelsBom as $bomGroup) {
                $valid = Model::validateMultiple($bomGroup) && $valid;
            }

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    foreach ($model as $i => $modelProduk) {
                        $modelProduk->pelanggan_id = $pelanggan_id;

                        if ($modelProduk->save(false)) {
                            // Ambil ID produk yang baru disimpan
                            $produkCustomId = $modelProduk->produk_custom_pelanggan_id;

                            // Simpan semua BOM terkait produk ini
                            if (isset($modelsBom[$i]) && is_array($modelsBom[$i])) {
                                foreach ($modelsBom[$i] as $bom) {
                                    $bom->produk_custom_pelanggan_id = $produkCustomId;

                                    if (!$bom->save()) {
                                        Yii::error([
                                            'error' => $bom->getErrors(),
                                            'data' => $bom->attributes
                                        ], 'bom_save_error');
                                        throw new \Exception('Gagal menyimpan salah satu BOM.');
                                    }
                                }
                            }
                        } else {
                            Yii::error($modelProduk->getErrors(), 'produk_save_error');
                            throw new \Exception('Gagal menyimpan salah satu produk.');
                        }
                    }

                    $transaction->commit();
                    return $this->redirect(['master-pelanggan/view', 'pelanggan_id' => $pelanggan_id]);
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    Yii::error($e->getMessage(), 'produk_create_error');
                    Yii::$app->session->setFlash('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
                }
            } else {
                // Jika validasi gagal, tampilkan error
                foreach ($model as $produk) {
                    foreach ($produk->getErrors() as $attr => $messages) {
                        Yii::$app->session->addFlash('error', "Produk: " . implode(', ', $messages));
                    }
                }
                foreach ($modelsBom as $bomGroup) {
                    foreach ($bomGroup as $bom) {
                        foreach ($bom->getErrors() as $attr => $messages) {
                            Yii::$app->session->addFlash('error', "BOM: " . implode(', ', $messages));
                        }
                    }
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'modelsBom' => $modelsBom,
            'pelanggan_id' => $pelanggan_id,
            'kode_pelanggan' => $pelanggan->kode,
            'lastNumber' => $lastNumber
        ]);
    }


    /**
     * Updates an existing ProdukCustomPelanggan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $produk_custom_pelanggan_id Produk Custom Pelanggan ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($pelanggan_id)
    {
        // --- Ambil pelanggan ---
        $pelanggan = MasterPelanggan::findOne($pelanggan_id);
        if (!$pelanggan) {
            throw new NotFoundHttpException('Data pelanggan tidak ditemukan.');
        }

        // --- Ambil produk terakhir (untuk tahu nomor urutan terakhir) ---
        $lastProduk = ProdukCustomPelanggan::find()
            ->where(['pelanggan_id' => $pelanggan_id])
            ->orderBy(['produk_custom_pelanggan_id' => SORT_DESC])
            ->one();

        if ($lastProduk && preg_match('/-(\d+)$/', $lastProduk->kode_barang, $matches)) {
            $lastNumber = (int)$matches[1];
        } else {
            $lastNumber = 0;
        }

        // --- Ambil data produk + bom lama dari DB ---
        $modelsProduk = ProdukCustomPelanggan::find()
            ->where(['pelanggan_id' => $pelanggan_id])
            ->with('bomCustom')
            ->all();

        $oldProdukIDs = ArrayHelper::map($modelsProduk, 'produk_custom_pelanggan_id', 'produk_custom_pelanggan_id');
        $modelsBom = [];
        $oldBomIDs = [];

        foreach ($modelsProduk as $i => $produk) {
            $modelsBom[$i] = $produk->bomCustom ?: [new BomCustom()];
            $oldBomIDs[$i] = ArrayHelper::map($produk->bomCustom, 'bom_custom_id', 'bom_custom_id');
        }

        // --- Jika POST (submit form) ---
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $produkPost = $post['ProdukCustomPelanggan'] ?? [];

            // ======================
            // (1) Bangun ulang daftar model produk berdasarkan data POST
            // ======================
            $modelsProdukNew = [];
            foreach ($produkPost as $idx => $prodData) {
                if (!empty($prodData['produk_custom_pelanggan_id']) && isset($oldProdukIDs[$prodData['produk_custom_pelanggan_id']])) {
                    $modelProduk = ProdukCustomPelanggan::findOne($prodData['produk_custom_pelanggan_id']);
                } else {
                    $modelProduk = new ProdukCustomPelanggan();
                }

                $modelProduk->load(['ProdukCustomPelanggan' => $prodData]);
                $modelsProdukNew[$idx] = $modelProduk;
            }

            // ======================
            // (2) Bangun ulang daftar model BOM berdasarkan data POST
            // ======================
            $modelsBomNew = [];
            $bomPost = $post['BomCustom'] ?? [];

            foreach ($modelsProdukNew as $idx => $produkModel) {
                $modelsBomNew[$idx] = [];

                if (!isset($bomPost[$idx]) || !is_array($bomPost[$idx])) {
                    continue;
                }

                foreach ($bomPost[$idx] as $j => $bomData) {
                    if (!empty($bomData['bom_custom_id']) && isset($oldBomIDs[$idx][$bomData['bom_custom_id']])) {
                        $bom = BomCustom::findOne($bomData['bom_custom_id']);
                    } else {
                        $bom = new BomCustom();
                    }
                    $bom->load(['BomCustom' => $bomData]);
                    $modelsBomNew[$idx][$j] = $bom;
                }
            }

            // ======================
            // (3) Validasi semua model
            // ======================
            $valid = Model::validateMultiple(array_values($modelsProdukNew));
            foreach ($modelsBomNew as $bomList) {
                $valid = Model::validateMultiple(array_values($bomList)) && $valid;
            }

            if ($valid) {
                // ======================
                // (4) Simpan semua data
                // ======================
                $newProdukIDs = [];

                foreach ($modelsProdukNew as $idx => $produkModel) {
                    $isNew = $produkModel->isNewRecord;

                    if ($isNew) {
                        $lastNumber++;
                        $produkModel->kode_barang = $pelanggan->kode . '-' . str_pad($lastNumber, 2, '0', STR_PAD_LEFT);
                    }

                    $produkModel->pelanggan_id = $pelanggan_id;
                    $produkModel->save(false);

                    $newProdukIDs[] = $produkModel->produk_custom_pelanggan_id;

                    // Simpan BOM
                    $newBomIDs = [];
                    if (!empty($modelsBomNew[$idx])) {
                        foreach ($modelsBomNew[$idx] as $bomModel) {
                            $bomModel->produk_custom_pelanggan_id = $produkModel->produk_custom_pelanggan_id;
                            $bomModel->save(false);
                            $newBomIDs[] = $bomModel->bom_custom_id;
                        }
                    }

                    // Hapus BOM yang dihapus dari form
                    $deletedBomIDs = array_diff($oldBomIDs[$idx] ?? [], $newBomIDs);
                    if (!empty($deletedBomIDs)) {
                        BomCustom::deleteAll(['bom_custom_id' => $deletedBomIDs]);
                    }
                }

                // ======================
                // (5) Hapus produk yang dihapus di form
                // ======================
                $deletedProdukIDs = array_diff($oldProdukIDs, $newProdukIDs);
                if (!empty($deletedProdukIDs)) {
                    BomCustom::deleteAll(['produk_custom_pelanggan_id' => $deletedProdukIDs]);
                    ProdukCustomPelanggan::deleteAll(['produk_custom_pelanggan_id' => $deletedProdukIDs]);
                }

                Yii::$app->session->setFlash('success', 'Data berhasil diperbarui.');
                return $this->redirect(['master-pelanggan/view', 'pelanggan_id' => $pelanggan_id]);
            }

            // Jika validasi gagal, kembalikan state form ke data yang baru diinput
            $modelsProduk = array_values($modelsProdukNew);
            $modelsBom = $modelsBomNew;
        }

        // --- Render halaman update ---
        return $this->render('update', [
            'pelanggan' => $pelanggan,
            'model' => $modelsProduk,
            'modelsBom' => $modelsBom,
            'pelanggan_id' => $pelanggan_id,
            'kode_pelanggan' => $pelanggan->kode,
            'lastNumber' => $lastNumber,
        ]);
    }



    /**
     * Deletes an existing ProdukCustomPelanggan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $produk_custom_pelanggan_id Produk Custom Pelanggan ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($produk_custom_pelanggan_id)
    {
        $this->findModel($produk_custom_pelanggan_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProdukCustomPelanggan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $produk_custom_pelanggan_id Produk Custom Pelanggan ID
     * @return ProdukCustomPelanggan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($produk_custom_pelanggan_id)
    {
        if (($model = ProdukCustomPelanggan::findOne(['produk_custom_pelanggan_id' => $produk_custom_pelanggan_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
