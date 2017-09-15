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
     * Creates a new Cita model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id_v)
    {
        $cita = new Cita();
        $locales = Local::findAll(['id_empresa' => Yii::$app->user->id]);
        $v = Vacante::findOne(["id" => $id_v, "id_empresa" => Yii::$app->user->id]);
        $va = $v->vacanteAspirantes;

        if ($cita->load(Yii::$app->request->post())) {
            $va = Yii::$app->request->post('VacanteAspirante')['id_aspirante'];
            if(is_array($va) && (count($va) <= $v->no_cita || $v->no_cita < 0)) {
                foreach($va as $i) {
                    $v->no_cita = $v->no_cita < 0 ? $v->no_cita:($v->no_cita - 1);

                    $i->estado = "aceptada";
                    $i->save();
                    $cita->id_va = $i->id;
                    //  Posible cambio a un unico sql que se ejecute al salir del foreach
                    $cita->save();
                }
                
                if($v->no_cita >= 0)
                    $v->save();
                
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
