<?php

namespace app\controllers;

use Yii;
use app\models\Cita;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
//  Las siguientes dos lineas son para el funcionamiento de los roles   //
use yii\filters\AccessControl;
use app\components\AccessRule;
//  Se agregan los siguientes modelos
use app\models\Local;
use app\models\VacanteAspirante;
use app\models\Vacante;

/**
 * CitaController implements the CRUD actions for Cita model.
 */
class CitaController extends Controller
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
                        'actions' => ['index', 'view'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true, 
                        'actions' => ['create', 'update'], 
                        'roles' => ['empresa'],
                    ],
                    // se agregaron permisos para aspirante
                    [
                        'allow' => true, 
                        'actions' => ['viewmovil','updateestado'], 
                        'roles' => ['aspirante'],
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
     * Lists all Cita models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Cita::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Cita model.
     * @param integer $id
     * @param integer $id_empresa
     * @return mixed
     */
    public function actionView($id, $id_empresa = 0)
    {
        return $this->render('view', [
            'model' => $this->findModel($id, $id_empresa),
        ]);
    }

    /**
     * Displays a single Cita model.
     * @param integer $id
     * @return mixed
     */
    public function actionViewmovil($id){
        $model = Cita::findOne(["id_va"=>$id]);
        if($model){
            return $this->render('viewmovil', ['model' => $model]);
        }
        else{
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionUpdateestado($id,$respuesta){
        $model = Cita::findOne(["id_va"=>$id]);
        if($model){
            $model->respuesta = $respuesta;
            if($model->save()){
                return $this->render('viewmovil', ['model' => $model]);
            }
            
        }
        else{
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }



    /**
     * Creates a new Cita model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $cita = new Cita();
        $locales = Local::findAll(['id_empresa' => Yii::$app->user->id]);
        $va = VacanteAspirante::find()->where(['id_vacante' => Yii::$app->request->get('vacante'), 'id_aspirante' => Yii::$app->request->get('aspirante')])->all();
        $vacante = Vacante::findOne(Yii::$app->request->get('vacante'));
        
        if (count($va) == 0) {
            Yii::$app->session->setFlash('error', 'Los aspirantes ingresados no estan asociados a la vacante');
            return $this->goBack((!empty(Yii::$app->request->referrer) ? Yii::$app->request->referrer : null));
        }

        if ($cita->load(Yii::$app->request->post())) {
            if (count($cita->id_va) <= $vacante->no_cita || $vacante->no_cita == -1) {
                $idVA = $cita->id_va;
                foreach($idVA as $i) {
                    $vacante->no_cita -= ($vacante->no_cita == -1 ? 0:1);
                    
                    $cita->id_va = $i;
                    $cita->estado = "aceptada";
                    
                    $cita->save();
                }
                $vacante->save();
                
                return $this->redirect(['view', 'id' => $cita->id]);
            } else {
                Yii::$app->session->setFlash('error', 'Excediste el numero de aspirantes que puedes citar');
            }
        }

        return $this->render('create', [
            'cita' => $cita,
            'locales' => $locales,
            'va' => $va,
        ]);
    }

    /**
     * Updates an existing Cita model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $id_empresa
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $cita = $this->findModel($id);
        $locales = Local::findAll(['id_empresa' => Yii::$app->user->id]);
        $msgError = null;
        
        if($cita->idVa->estado == "negada")
            $msgError = "rechazaste al aspirante";
        else if($cita->idVa->idVacante->fecha_finalizacion < date('Y-m-d'))
            $msgError = "la vacante finalizo";
        else if(preg_match("/^si asistire/i", $cita->respuesta))
            $msgError = "el aspirante acepto las condiciones de la cita";
        
        if($msgError !== null) {
            Yii::$app->session->setFlash('error', 'La cita no puede ser editada ya que ' . $msgError);
            return $this->redirect(['view', 'id' => $model->id, 'id_empresa' => $model->id_empresa]);
        }
        
        

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'id_empresa' => $model->id_empresa]);
        }
        
        return $this->render('update', [
            'cita' => $model,
            'locales' => $locales,
            'va' => array($cita->idVa),
        ]);
    }

    /**
     * Deletes an existing Cita model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $id_empresa
     * @return mixed
     */
    /*  Posible reutilizacion con cambios o eliminacion
    public function actionDelete($id, $id_empresa)
    {
        $this->findModel($id, $id_empresa)->delete();

        return $this->redirect(['index']);
    }*/

    /**
     * Finds the Cita model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $id_empresa
     * @return Cita the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $id_empresa = 0)
    {
        $id_empresa = Yii::$app->user->identity->rol == "empresa" ? Yii::$app->user->id:$id_empresa;
        if (($model = Cita::findOne(['id' => $id, 'id_empresa' => $id_empresa])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
