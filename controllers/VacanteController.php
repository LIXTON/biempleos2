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
                        'actions' => ['index', 'create', 'update'],
                        'roles' => ['empresa'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
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
     * El index representa todas las vacantes
     * que no hayan expirado ni finalizado
     * creadas por la empresa.
     * 
     * El aspirante ve las vacantes que aplico
     * en index vacanteaspirante
     * 
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Vacante::find()->where(['id_empresa' => Yii::$app->user->id])->andWhere('fecha_finalizacion >= :fecha', [':fecha' => date("Y-m-d")]),
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
            'query' => Vacante::find()->where(['id_empresa' => Yii::$app->user->id])->andWhere('not', ['fecha_finalizacion' => null]),
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
        $vacante = new Vacante();
        $ep = EmpresaPaquete::find()->where(['id_empresa' => Yii::$app->user->id])->andWhere('fecha_expiracion >= :fecha', [':fecha' => date("Y-m-d")])->all();
        $local = Local::findAll(['id_empresa' => Yii::$app->user->id, 'activo' => true]);

        if (count($local) == 0) {
            Yii::$app->session->setFlash('error', 'Necesitas registrar al menos un local activo para crear vacantes.');
            return $this->redirect(['local/create']);
        }
        
        if (count($ep) == 0) {
            Yii::$app->session->setFlash('error', 'Necesitas tener activo algun paquete si deseas continuar.');
            return $this->redirect(['index']);
        }

        if ($vacante->load(Yii::$app->request->post())) {
            $ep = array_filter($ep, function ($x) { return $x->id == Yii::$app->request->post('EmpresaPaquete')['id']; });
            if(count($ep) == 0)
                throw new BadRequestHttpException('There is no plan selected');
            
            $ep = $ep[0];
            if ($ep->fecha_expiracion >= date('Y-m-d')) {
                if ($ep->no_vacante > 0) {
                    $ep->no_vacante -= 1;
                    $ep->save();
                }
                $vacante->fecha_finalizacion = $ep->fecha_expiracion;
                $vacante->fecha_publicacion = Yii::$app->request->post("publicar") ? date("Y-m-d H:i:s"):null;
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
        $vacante = $this->findModel($id, 0, $id_local);
        $local = Local::findAll(['id_empresa' => Yii::$app->user->id, 'activo' => true]);
        $msgError = null;
        
        if ($isUnavaliable = !empty($vacante->fecha_publicacion))
            $msgError = "La vacante no puede ser editada debido a que fue publicada.";
        else if ($isUnavaliable = $vacante->fecha_finalizacion < date('Y-m-d'))
            $msgError = "La vacante no puede ser editada debido a que finalizo el tiempo de contratacion.";
        
        if ($isUnavaliable) {
            Yii::$app->session->setFlash('error', $msgError);
            return $this->redirect(['index']);
        }

        if ($vacante->load(Yii::$app->request->post())) {
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
        $id_empresa = Yii::$app->user->identity->rol == 'empresa' ? Yii::$app->user->id:$id_empresa;
        $model = Vacante::findOne(['id' => $id, 'id_empresa' => $id_empresa, 'id_local' => $id_local]);
        //$model = $active ? Vacante::findOne(['id' => $id, 'id_empresa' => $id_empresa, 'id_local' => $id_local, 'fecha_finalizacion' => null]):Vacante::find()->where(['id' => $id, 'id_empresa' => $id_empresa, 'id_local' => $id_local])->andWhere(['not',['fecha_finalizacion' => null]])->one();
            
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
