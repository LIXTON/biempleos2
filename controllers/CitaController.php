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
//  Se agrega lo siguiente para las notificaciones android
use app\assets\ejemploFCM;

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
                        'actions' => ['index', 'index-vacante', 'create', 'update', 'view'], 
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
     * Lists all Cita models in user_empresa.
     * @return mixed
     */
    public function actionIndex()
    {
        /*$query = (new \yii\db\Query())
            ->select(['vacante.puesto' => 'vacante', 'cita.fecha' => 'fecha'])
            ->from('cita')
            ->leftJoin('vacante_aspirante', 'vacante_aspirante.id = cita.id_va')
            ->leftJoin('vacante', 'vacante.id = vacante_aspirante.id_vacante')
            ->where(['cita.id_empresa' => Yii::$app->user->id])
            ->andWhere('cita.fecha >= :fecha', [':fecha' => date('Y-m-d H:i:s')]);*/
        $dataProvider = new ActiveDataProvider([
            'query' => Cita::find()
            ->select(['vacante' => 'vacante.puesto', 'fecha' => 'cita.fecha'])
            ->joinWith('idVa.idVacante')
            ->where(['cita.id_empresa' => Yii::$app->user->id])
            ->andWhere('cita.fecha >= :fecha', [':fecha' => date('Y-m-d H:i:s')])
            ->groupBy('fecha, vacante')
            ->orderBy('fecha ASC'),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Lists all Cita models from a specific vacante and is in user_empresa.
     * @return mixed
     */
    public function actionIndexVacante($id)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Cita::find()
            ->select(['fecha' => 'cita.fecha', 'direccion' => 'cita.direccion', 'local' => 'CONCAT(ISNULL(local.calle, \'\'), \' #\', ISNULL(local.numero, \'\'), \' ,\', ISNULL(local.colonia, \'\'), \' CP\', ISNULL(local.codigo_postal, \'\'))'])
            ->joinWith(['idVa.idVacante', 'idLocal'])
            ->where(['cita.id_empresa' => Yii::$app->user->id])
            ->andWhere('cita.fecha >= :fecha', [':fecha' => date('Y-m-d H:i:s')])
            ->andWhere(['vacante.id' => $id])
            //->groupBy('fecha')
            orderBy('fecha ASC'),
        ]);

        return $this->render('indexvacante', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Cita model.
     * @param integer $id
     * @param integer $id_empresa
     * @return mixed
     */
    public function actionView($id, $fecha)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Cita::find()
            ->select(['aspirante' => 'solicitud.nombre', 'respuesta' => 'cita.respuesta', 'fecha' => 'cita.fecha', 'direccion' => 'cita.direccion', 'local' => 'CONCAT(ISNULL(local.calle, \'\'), \' #\', ISNULL(local.numero, \'\'), \' ,\', ISNULL(local.colonia, \'\'), \' CP\', ISNULL(local.codigo_postal, \'\'))'])
            ->joinWith(['idVa.idAspirnte.solicitud', 'idLocal', 'idVa.idVacante'])
            ->where(['cita.id_empresa' => Yii::$app->user->id])
            ->andWhere(['vacante.id' => $id])
            ->andWhere('cita.fecha >= :fecha', [':fecha' => date('Y-m-d H:i:s')])
            ->andWhere(['like', 'cita.fecha', $fecha]),
        ]);
        
        return $this->render('view', [
            'dataProvider' => $dataProvider,
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
                $idsVA = $cita->id_va;
                foreach($idsVA as $i) {
                    $vacante->no_cita -= ($vacante->no_cita == -1 ? 0:1);
                    
                    $cita->id_va = $i;
                    $cita->save();
                    
                    $updateVA = $cita->idVa;
                    $updateVA->estado = "aceptada";
                    $updateVA->fecha_cambio_estado = date('Y-m-d H:i:s');
                    $updateVA->save();
                    
                    $aspirante = $updateVA->idAspirante;
                    
                    if ($aspirante !== null && !empty($aspirante->gcm))
                        send_FCM($aspirante->gcm, 'TITULO BIE', $cita->mensaje, 'SUBTITULO');
                }
                $vacante->save();
                
                Yii::$app->session->setFlash('success', 'La cita se ha notificado a los aspirantes');
                
                return $this->redirect(['view', 'idVA' => $cita->id_va, 'fecha' => $cita->fecha]);
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
        
        $fecha = new DateTime($cita->fecha);
        
        if($cita->idVa->estado == "negada")
            $msgError = "rechazaste al aspirante";
        else if($cita->idVa->idVacante->fecha_finalizacion < date('Y-m-d'))
            $msgError = "la vacante finalizo";
        else if(preg_match("/^si asistire/i", $cita->respuesta))
            $msgError = "el aspirante acepto las condiciones de la cita";
        
        if($msgError !== null) {
            Yii::$app->session->setFlash('error', 'La cita no puede ser editada ya que ' . $msgError);
            return $this->redirect(['view', 'id' => $cita->idVa->idVacante->id, 'id_empresa' => $fecha->format('Y-m-d')]);
        } else if ($cita->respuesta == "si asistire") {
            Yii::$app->session->setFlash('error', 'El aspirante ya acepto ir');
            return $this->redirect(['view', 'id' => $cita->idVa->idVacante->id, 'id_empresa' => $fecha->format('Y-m-d')]);
        }

        
        
        $va = array($cita->idVa);
        $vacante = $va->idVacante;

        if ($cita->load(Yii::$app->request->post())) {
                $cita->id_va = $cita->id_va[0];
                $cita->save();

                $aspirante = $va[0]->idAspirante;

                if ($aspirante !== null && !empty($aspirante->gcm))
                    send_FCM($aspirante->gcm, 'TITULO BIE', $cita->mensaje, 'SUBTITULO');
                
                Yii::$app->session->setFlash('success', 'La cita se ha notificado al aspirante');
                
                return $this->redirect(['view', 'idVA' => $cita->id_va, 'fecha' => $cita->fecha]);
        }
        
        
        
        return $this->render('update', [
            'cita' => $cita,
            'locales' => $locales,
            'va' => $va,
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
