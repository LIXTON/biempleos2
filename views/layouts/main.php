<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use yii\widgets\Pjax;
use app\assets\AppAsset;
use app\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<?php
NavBar::begin([
    'brandLabel' => 'My Company',
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse',
    ],
]);
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => [
        ['label' => 'Home', 'url' => ['/site/index']],
        ['label' => 'About', 'url' => ['/site/about']],
        ['label' => 'Contact', 'url' => ['/site/contact']],
        Yii::$app->user->isGuest ? (
            ['label' => 'Login', 'url' => ['/site/login']]
        ) : (
            '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->correo . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>'
        )
    ],
]);
NavBar::end();
?>


<div class="container">
    <?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>
    <div class="container alert-row">
        <?php
        Pjax::begin(['id' => 'alerta-msg']);
        echo Alert::widget([
            'options' => [
                'class' => 'col-xs-12 col-sm-6 col-sm-offset-3 text-center',
                'style' => 'position: absolute; left: 0;',
            ],
        ]);
        Pjax::end();
        ?>
    </div>
    <?= $content ?>
</div>

<footer class="container-fluid text-center">
    <div class="col-sm-2">
        <?= Html::img('@web/images/logo.png') ?>
    </div>
    <div class="col-sm-8">
        <div class="col-sm-4">
            <a class="btn btn-link">Sobre nosotros</a>
        </div>
        <div class="col-sm-4">
            <a class="btn btn-link">Información a empresa</a>
        </div>
        <div class="col-sm-4">
            <a class="btn btn-link">Ayuda</a>
        </div>
        <div class="col-sm-4 col-sm-offset-2">
            Enlaces
            <hr>
            <?php echo Html::a('Términos y Condiciones', ['site/terminos']); ?><br>
            <?php echo Html::a('Política de Privacidad', ['site/politicas']); ?>
        </div>
        <div class="col-sm-4">
            <a class="btn btn-link">Contacto</a>
        </div>
    </div>
    <div class="col-sm-2">
        <p class="col-xs-12">Siguenos en</p>
        <a href="https://twitter.com/biempleos"><?= Html::img('@web/images/twitter-logo-button.png') ?></a>
        <a href="https://www.facebook.com/biempleos/?__mref=message_bubble"><?= Html::img('@web/images/facebook-logo-button.png') ?></a>
    </div>
    <p class="col-xs-12">&#169; BIE 2017<br><sub>Powered by BOSON SOFTWARE DEVELOPMENT</sub></p>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
