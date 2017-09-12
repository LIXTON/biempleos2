<?php

namespace app\controllers;

use Yii;
use app\models\Vacante;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\EmpresaPaquete;
use app\models\Local;
use app\widgets\Alert;
//  Las siguientes dos lineas son para el funcionamiento de los roles   //
use yii\filters\AccessControl;
use app\components\AccessRule;
//  Se utiliza en caso de errores de datos introducidos o bien          //
//  alteracion de datos                                                 //
use yii\web\BadRequestHttpException;

/**
 * VacanteController implements the CRUD actions for Vacante model.
 */
class VacanteController extends Controller
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
                        'actions' => ['create', 'update', 'historial'],
                        'roles' => ['empresa'],
                    ],
                    [
                        'allow' => true,
<<<<<<< HEAD
                        'actions' => ['view','indexmovil'],
=======
                        'actions' => ['index', 'view'],
>>>>>>> 9aa76975fc31fe980287b07fd6f1cd6187790ea8
                        'roles' => ['@'],
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
     * Lists all Vacante models.
     * Empresa:
     * Muestra las vacantes creadas por la empresa
     * y que no hayan finalizado
     *
     * Aspirante:
     * Muestra todas las vacantes que no hayan finalizado
     * 
     * @return mixed
     */
    public function actionIndex()
    {
        $query = Vacante::find()->where('fecha_finalizacion >= :fecha', [':fecha' => date("Y-m-d")]);
        switch(Yii::$app->user->identity->rol) {
            case "empresa":
                $query = $query->andWhere(['id_empresa' => Yii::$app->user->id]);
                break;
            case "aspirante":
                $query = $query->andWhere(['not', ['fecha_publicacion' => null]]);
                break;
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Vacante models.
     * YOLO cree otro index para movil
     * 
     * @return mixed
     */
    public function actionIndexmovil()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Vacante::find()->where(['fecha_finalizacion' => null])->andWhere('fecha_expiracion >= :fecha', [':fecha' => date("Y-m-d")]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Lists all Vacante models.
     * El historial representa todas las vacantes
     * expiradas o finalizadas creadas por la empresa.
     * 
     * El aspirante ve su historial que aplico
     * en historial vacanteaspirante
     * 
     * @return mixed
     */
    public function actionHistorial()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Vacante::find()->where(['id_empresa' => Yii::$app->user->id])->andWhere('fecha_finalizacion < :fecha', [':fecha' => date("Y-m-d")]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Vacante model.
     * @param integer $id
     * @param integer $id_empresa
     * @param integer $id_local
     * @return mixed
     */
    public function actionView($id, $id_empresa, $id_local)
    {
        //  EN ESTA VISTA DEBE AGREGARSE LAS OPCIONES DE CITA DEL ASPIRANTE     //
        return $this->render('view', [
            'model' => $this->findModel($id, $id_empresa, $id_local),
        ]);
    }

    /**
     * Creates a new Vacante model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        //  Se crea una vacante asi como se cargan los datos del paquete contratado y   //
        //  los locales registrados que se encuentren activos                           //
        $vacante = new Vacante();
        $ep = EmpresaPaquete::find()->where(['id_empresa' => Yii::$app->user->id])->andWhere('fecha_expiracion >= :fecha', [':fecha' => date("Y-m-d")])->all();
        $local = Local::findAll(['id_empresa' => Yii::$app->user->id, 'activo' => true]);

        //  Si no hay locales registrados redirecciona a registrar uno y muestra el error   //
        if (count($local) == 0) {
            Yii::$app->session->setFlash('error', 'Necesitas registrar al menos un local activo para crear vacantes.');
            return $this->redirect(['local/create']);
        }
        
        //  Si no hay paquetes contratados redirecciona al index y muestra el error   //
        if (count($ep) == 0) {
            Yii::$app->session->setFlash('error', 'Necesitas tener activo algun paquete si deseas continuar.');
            return $this->redirect(['index']);
        }

        if ($vacante->load(Yii::$app->request->post())) {
            //  Para evitar hacer llamadas a sql se utiliza una variable ya cargada     //
            //  y se procede a buscar el elemento seleccionado en el _form              //
            //  El elemento encontrado es un array y solo es el primero                 //
            $ep = array_filter($ep, function ($x) { return $x->id == Yii::$app->request->post('EmpresaPaquete')['id']; });
            //  Este codigo se ejecuta en caso de alguna alteracion en el input del paquete //
            if(count($ep) == 0)
                throw new BadRequestHttpException('There is no plan selected');
            
            $ep = $ep[0];
            //  Se verifica si aun es valido el paquete caso contrario redirecciona     //
            //  a index y muestra el error                                              //
            if ($ep->fecha_expiracion >= date('Y-m-d')) {
                //  Valor negativo representa infinito caso contrario se procede a      //
                //  restar la cantidad de vacantes en el paquete contratado             //
                if ($ep->no_vacante > 0) {
                    $ep->no_vacante -= 1;
                    $ep->save();
                }
                //  La finalizacion de una vacante es la misma del paquete seleccionado //
                $vacante->fecha_finalizacion = $ep->fecha_expiracion;
                //  La vacante se publica si la empresa oprimio publicar                //
                $vacante->fecha_publicacion = Yii::$app->request->post("publicar") ? date("Y-m-d H:i:s"):null;
                //  La cantidad de citas es la misma que el paquete seleccionado        //
                //  Estas se restan cuando se solicita alguna cita                      //
                $vacante->no_cita = $ep->idPaquete->no_cita;
                $vacante->save();
                
                return $this->redirect(['view', 'id' => $vacante->id, 'id_empresa' => Yii::$app->user->id, 'id_local' => $vacante->id_local]);
            } else {
                Yii::$app->session->setFlash('error', "No puede crearse la vacante debido a que expiro el paquete contratado.");
                return $this->redirect(['index']);
            }
        }
        
        return $this->render('create', [
            'vacante' => $vacante,
            'ep' => $ep,
            'local' => $local,
        ]);
    }

    /**
     * Updates an existing Vacante model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $id_empresa
     * @param integer $id_local
     * @return mixed
     */
    public function actionUpdate($id, $id_local)
    {
        //  Se carga la vacante seleccionada asi como los locales registrados que se    //
        //  encuentran activos                                                          //
        $vacante = $this->findModel($id, 0, $id_local);
        $local = Local::findAll(['id_empresa' => Yii::$app->user->id, 'activo' => true]);
        $msgError = null;
        
        //  Se crea un mensaje de error si la vacante no puede ser editada debido a     //
        //  que fue publicada o si expiro                                               //
        if ($isUnavaliable = !empty($vacante->fecha_publicacion))
            $msgError = "La vacante no puede ser editada debido a que fue publicada.";
        else if ($isUnavaliable = $vacante->fecha_finalizacion < date('Y-m-d'))
            $msgError = "La vacante no puede ser editada debido a que finalizo el tiempo de contratacion.";
        
        if ($isUnavaliable) {
            Yii::$app->session->setFlash('error', $msgError);
            return $this->redirect(['index']);
        }

        if ($vacante->load(Yii::$app->request->post())) {
            //  La vacante se publica si la empresa oprimio publicar                    //
            $vacante->fecha_publicacion = Yii::$app->request->post("publicar") ? date("Y-m-d H:i:s"):null;
            $vacante->save();
            return $this->redirect(['view', 'id' => $vacante->id, 'id_empresa' => $vacante->id_empresa, 'id_local' => $vacante->id_local]);
        }
        
        return $this->render('update', [
            'vacante' => $vacante,
            'local' => $local,
            'ep' => null,
        ]);
    }

    /**
     * Deletes an existing Vacante model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $id_empresa
     * @param integer $id_local
     * @return mixed
     */
    /*  Posible reutilizacion con cambios o eliminacion
    public function actionDelete($id, $id_local)
    {
        $this->findModel($id, Yii::$app->user->id, $id_local)->delete();

        return $this->redirect(['index']);
    }*/

    /**
     * Finds the Vacante model based on its primary key value and if is active or not.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $id_empresa
     * @param integer $id_local
     * @return Vacante the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $id_empresa, $id_local)
    {
        //  Si una empresa inicio sesion el id_empresa se busca por la sesion no por la introducida     //
        $model = null;
        switch (Yii::$app->user->identity->rol) {
            case "empresa":
                $model = Vacante::findOne(['id' => $id, 'id_empresa' => Yii::$app->user->id, 'id_local' => $id_local]);
                break;
            case "aspirante":
                $model = Vacante::find()->where(['id' => $id, 'id_empresa' => $id_empresa, 'id_local' => $id_local])->andWhere(['not', ['fecha_publicacion' => null]])->one();
                break;
        }

        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
