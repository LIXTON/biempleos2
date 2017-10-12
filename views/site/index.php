<?php

/* @var $this yii\web\View */
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\widgets\ActiveForm;
use app\assets\IndexAsset;
use app\models\LoginForm;
use app\widgets\Alert;

IndexAsset::register($this);

$this->title = 'My Yii Application';
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <?= Html::img('@web/images/logo.png', ['class' => 'img-logo-index']) ?>
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu">
                    <?= Html::img('@web/images/icon2.png', ['width' => '44px']) ?>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="menu">
                <div class="nav navbar-right">
                    <?php
                    $login = new LoginForm();
                    $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'options' => [
                            'class' => "navbar-form navbar-left",
                        ],
                        'fieldConfig' => [
                            'template' => "<div class=\"form-group\">{input}</div>",
                        ],
                    ]);
                    echo $form->field($login, 'correo', [
                            'inputOptions' => [
                                'placeholder' => $login->getAttributeLabel('correo'),
                                'class' => 'form-control',
                            ],
                        ])->textInput()->label(false);
                    echo $form->field($login, 'contrasena', [
                            'inputOptions' => [
                                'placeholder' => $login->getAttributeLabel('contrasena'),
                                'class' => 'form-control',
                            ],
                        ])->passwordInput()->label(false);

                    echo Html::submitButton('Iniciar Sesión', ['class' => 'btn btn-success']);
                    ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="section1 row text-center">
            <h1 class="col-xs-12">Tú eliges a quien contratar <?= Html::img('@web/images/icon1.png') ?></h1>
            <h1 class="col-xs-12">Tú eliges donde trabajar <?= Html::img('@web/images/engineer.png') ?></h1>
            <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                <button class="btn btn-lg btn-success col-sm-5">BUSCAR EMPLEO</button>
                <?php echo Html::a('CONTRATAR', "#", ['class' => 'btn btn-lg btn-danger col-sm-offset-2 col-sm-5']); ?>
            </div>
        </div>
        <div class="section2 row">
            <div class="col-sm-offset-5 col-sm-7 col-xs-12">
                <h1>Es fácil</h1>
                <p>En BIE tenemos las mejores ofertas, visualiza de forma sencilla pero detallada cada oferta, seguro encuentras algo para ti.</p>
                
                <h1>Encuentra Empleo</h1>
                <p>Evita las contingencias de la ciudad y todo el agotamiento de buscar trabajo, selecciona las ofertas que mas te gusten y envia tu solicitud.</p>
                
                <h1>Adiós papel</h1>
                <p>En BIE, como empleador, podras visualizar las solicitudes de empleo, además de guardar solicitudes en formato digital para una mejor administración.</p>
            </div>
        </div>
        <div class="section3 row text-center">
            <h2 class="col-xs-12">Disfruta de BIE en tus dispositivos</h2>
            <?= Html::img('@web/images/google-play-badge.png') ?>
        </div>
        <footer class="row text-center">
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
    </div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>