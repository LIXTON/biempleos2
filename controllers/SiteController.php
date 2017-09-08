<?php
namespace app\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\LoginForm;
use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;
use app\models\SignupForm;
use app\models\ContactForm;
use app\models\Aspirante;
use app\models\Solicitud;

use app\models\Empresa;
use app\models\EmpresaPaquete;
use app\models\Paquete;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signupw', 'signupm', 'chgpassword'],
                'rules' => [
                    [
                        'actions' => ['signupw', 'signupm'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    // se agrego el codigo de las rules, no funciona hasta que no tenga el custom rule que se creo
                    // pd. el custom rule que se creo tiene bug, mayor referencia ver documento SolicitudController.php
                    [
                        'allow' => true,
                        'actions' => ['movilmenu'],
                        'roles' => ['aspirante'],
                    ],
                    [
                        'actions' => ['logout', 'chgpassword'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = false;
        
        if(!Yii::$app->user->isGuest) {
            switch(Yii::$app->user->identity->rol) {
                case 'empresa':
                    return $this->redirect(['//empresa/view', 'id' => Yii::$app->user->id]);
                case 'aspirante':
                    $gcm = Yii::$app->user->identity->aspirante->gcm;
                    if(empty($gcm))
                        return $this->redirect(['//aspirante/view', 'id' => Yii::$app->user->id]);
                    else
                        return $this->actionMovilmenu();
                case 'admin':
                    return $this->redirect(['//paquete/index']);
            }
        }
        
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if(!empty(Yii::$app->request->post('gcm'))) {
            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                // Obteniendo al aspirante para asignarle la GCM Key
                $aspirante = Aspirante::findOne(Yii::$app->user->id);
                // se asigna la gcm key al aspirante
                $aspirante->gcm = Yii::$app->request->post('gcm');
                // guardando cambios
                $aspirante->save();
                
                return $this->actionMovilmenu();
            }   
        } else {
            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                return $this->goBack();
            }
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Nueva action creada para redireccionar al usuario movil
     *
     * @return mixed
     */
    public function actionMovilmenu(){
        // cargamos datos del aspirante //
        $solicitud = Solicitud::findOne(Yii::$app->user->id);
        // se crea el contenedor de datos //
        $data = array("nombre"=>"no set");
        // se valida que cargo la solicitud //
        if($solicitud){
            // cargamos datos en el contenedor //
            $data = array("nombre"=>$solicitud->nombre);
        }
        // cargamos el render y mandamos la información //
        return $this->render("movilmenu", array("data"=>$data));
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
    
    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionPoliticas()
    {
        return $this->render('politicas');
    }
    
    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionTerminos()
    {
        return $this->render('terminos');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignupw()
    {
        // Variable $model se cambio por $signup //
        $signup = new SignupForm();
        // Se crea una empresa //
        $empresa = new Empresa();
        if ($signup->load(Yii::$app->request->post())) {
            if ($user = $signup->signup('empresa')) {
                
                if (Yii::$app->getUser()->login($user)) {
                    if ($empresa->load(Yii::$app->request->post()) && $empresa->save()) {
                        // Se crea el paquete gratuito de 1 mes a la empresa //
                        $empresaPaquete = new EmpresaPaquete();
                        $empresaPaquete->id_empresa = $user->id;
                        $empresaPaquete->id_paquete = Paquete::findOne(['precio' => 0])->id;
                        $empresaPaquete->fecha_expiracion = date('Y-m-d', strtotime("+1 month"));//'Y-m-d H:i:s'
                    }
                    return $this->goHome();
                }
            }
        }

        return $this->render('signupw', [
            'signup' => $signup,
            'empresa' => $empresa,
        ]);
    }
    
    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignupm()
    {
        // Variable $model se cambio por $signup //
        $signup = new SignupForm();
        if ($signup->load(Yii::$app->request->post())) {
            if ($user = $signup->signup('aspirante')) {
                // se crea un aspirante //
                $aspirante = new Aspirante();
                // se le asigna el id del user creado //
                $aspirante->id_usuario = $user->id;
                // se crea un gcm temporal "not set"
                $aspirante->gcm = "not set";
                // se activa su cuenta //
                $aspirante->activo = 1;

                // se guardan los cambios //
                $aspirante->save();

                return $this->redirect(['site/login']);
            }
        }

        return $this->render('signupm', [
            'signup' => $signup,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
    
    /**
     * Change password. Realiza el cambio de la contraseña del usuario
     * Lo redirige a una pagina en especifico dependiendo del rol
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionChgpassword()
    {
        $chgPassword = new \app\models\chgPasswordForm();

        if(Yii::$app->request->isAjax && $chgPassword->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($chgPassword);
        }

        if ($chgPassword->load(Yii::$app->request->post()) && $chgPassword->validate()) {
            Yii::$app->user->identity->setPassword($chgPassword->new_contrasena);
            if(Yii::$app->user->identity->save())
                Yii::$app->session->setFlash('success', 'Tu contraseña se ha cambiado exitosamente');
            else
                Yii::$app->session->setFlash('error', 'Ocurrio un problema al cambiar tu contraseña.<br>Intentalo mas tarde.');
            
            switch(Yii::$app->user->identity->rol) {
                case "empresa":
                    return $this->redirect(['//empresa/view', 'id' => Yii::$app->user->id]);
                case "aspirante":
                    return $this->redirect(['//aspirante/view', 'id' => Yii::$app->user->id]);
            }
        }
        
        return $this->render('chgPassword', [
            'chgPassword' => $chgPassword,
        ]);
    }
}
