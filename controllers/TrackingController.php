<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\PermintaanPelanggan;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

class TrackingController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['status'], // Action yang ingin diatur
                'rules' => [
                    [
                        'actions' => ['status'],
                        'allow' => true,
                        'roles' => ['?'], // '?' berarti tamu/guest (belum login)
                    ],
                    [
                        'actions' => ['status'],
                        'allow' => true,
                        'roles' => ['@'], // '@' berarti user yang sudah login juga bisa lihat
                    ],
                ],
            ],
        ];
    }
    public $layout = 'public_tracking'; // Gunakan layout khusus yang bersih tanpa menu admin

    public function actionStatus($token)
    {
        $so = PermintaanPelanggan::findOne(['tracking_token' => $token]);
        if (!$so) {
            throw new NotFoundHttpException("Halaman tracking tidak ditemukan.");
        }

        return $this->render('status', [
            'so' => $so,
        ]);
    }
}
