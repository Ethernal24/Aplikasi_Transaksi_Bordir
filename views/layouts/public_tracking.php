<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use yii\helpers\Url;
use yii\bootstrap5\Html;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <title><?= Html::encode($this->title) ?></title>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="<?= Yii::getAlias('@web') ?>/assets/images/diwarna-logo-png.png" type="image/x-icon">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .tracking-navbar {
            background: #ffffff;
            border-bottom: 2px solid #007bff;
            padding: 15px 0;
            margin-bottom: 30px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .footer {
            padding: 20px 0;
            background: #ffffff;
            margin-top: 50px;
            border-top: 1px solid #dee2e6;
        }

        .logo-text {
            font-weight: 800;
            color: #007bff;
            font-size: 1.5rem;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <?php $this->beginBody() ?>

    <nav class="tracking-navbar">
        <div class="container text-center">
            <a href="#" class="logo-text">
                INFORMASI TRACKING
            </a>
        </div>
    </nav>

    <main role="main" class="flex-shrink-0">
        <div class="container">
            <?= $content ?>
        </div>
    </main>

    <footer class="footer">
        <div class="container text-center text-muted">
            <p>&copy; <?= date('Y') ?> <?= Html::encode(Yii::$app->name) ?> - Jasa Konveksi Profesional</p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>