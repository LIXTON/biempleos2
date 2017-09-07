<?php

namespace app\controllers;

use Yii;
use app\models\Empresa;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
//  Las siguientes dos lineas son para el funcionamiento de los roles   //
use yii\filters\AccessControl;
use app\components\AccessRule;

/**
 * EmpresaController implements the CRUD actions for Empresa model.
 */
class EmpresaController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                // Se crea un nuevo AccessRule para lidiar con los roles //
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'update'],
                        'roles' => ['empresa'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Empresa models.
     * @return mixed
     */
    /*  Posible reutilizacion con cambios o eliminacion */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Empresa::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Empresa model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'empresa' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Empresa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    /*public function actionCreate()
    {
        $empresa = new Empresa();

        if ($empresa->load(Yii::$app->request->post()) && $empresa->save()) {
            return $this->redirect(['view', 'id' => $empresa->id_usuario]);
        } else {
            return $this->render('create', [
                'empresa' => $empresa,
            ]);
        }
    }*/

    /**
     * Updates an existing Empresa model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    /*  Posible reutilizacion con cambios o eliminacion
    public function actionUpdate($id)
    {
        $empresa = $this->findModel($id);
        
        $chgPassword = new \app\models\chgPasswordForm();

        if(Yii::$app->request->isAjax && $chgPassword->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($chgPassword);
        }

        if ($chgPassword->load(Yii::$app->request->post()) && $chgPassword->validate()) {
            //$user = User::findByCorreo(Yii::$app->user->identity->correo);
            //$user->setPassword($chgPassword->contrasena);
            
            Yii::$app->user->identity->setPassword($chgPassword->new_contrasena);
            if(Yii::$app->user->identity->save())
                Yii::$app->session->setFlash('success', 'Tu contraseña se ha cambiado exitosamente');
            else
                Yii::$app->session->setFlash('error', 'Ocurrio un problema al cambiar tu contraseña.<br>Intentalo mas tarde.');
            return $this->redirect(['view', 'id' => $empresa->id_usuario]);
        }
        
        return $this->render('update', [
            'empresa' => $empresa,
            'chgPassword' => $chgPassword,
        ]);
    }*/

    /**
     * Deletes an existing Empresa model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    /*public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }*/

    /**
     * Finds the Empresa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Empresa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($empresa = Empresa::findOne($id)) !== null) {
            return $empresa;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
