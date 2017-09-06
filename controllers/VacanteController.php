<?php

namespace app\controllers;

use Yii;
use app\models\Vacante;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\EmpresaPaquete;
use app\widgets\Alert;

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
                    'class' => app\components\AccessRule::className(),
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create', 'update'],
                        'roles' => ['empresa'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'view'],
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
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Vacante::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Vacante model.
     * @param integer $id
     * @param integer $id_usuario
     * @param integer $id_local
     * @return mixed
     */
    public function actionView($id, $id_usuario, $id_local)
    {
        return $this->render('view', [
            'model' => $this->findModel($id, $id_usuario, $id_local),
        ]);
    }

    /**
     * Creates a new Vacante model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Vacante();
        $empresaPaquete = EmpresaPaquete::findAll(['id_empresa' => Yii::$app->user->id]);

        if ($model->load(Yii::$app->request->post())) {
            $empresaPaquete = EmpresaPaquete::findOne(['id' => Yii::$app->request->post('id_paquete'), 'id_empresa' => Yii::$app->user->id]);
            if ($empresaPaquete !== null) {
                $isAvaliable = ($empresaPaquete->no_vacante > 0 || $empresaPaquete->no_vacante == -1) && $empresaPaquete->fecha_expiracion < date("Y-m-d");
                
                if ($isAvaliable) {
                    if ($empresaPaquete->no_vacante > 0) {
                        $empresaPaquete->no_vacante -= 1;
                        $empresaPaquete->save();
                    }
                    
                    if ($model->save()) {
                        return $this->redirect(['view', 'id' => $model->id, 'id_usuario' => $model->id_usuario, 'id_local' => $model->id_local]);
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'El tiempo o cantidad de vacantes que puedes manejar llego a su limite.<br>Compra algun paquete para que puedas seguir trabajando');
                }
            } else {
                Yii::$app->session->setFlash('error', 'Ocurrio un error y el sistema no puede procesar la acción.<br>Intentalo más tarde.');
            }
            
            $this->actionIndex();
        }
        
        return $this->render('create', [
            'model' => $model,
            'empresaPaquete' => $empresaPaquete,
        ]);
    }

    /**
     * Updates an existing Vacante model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $id_usuario
     * @param integer $id_local
     * @return mixed
     */
    public function actionUpdate($id, $id_usuario, $id_local)
    {
        $model = $this->findModel($id, $id_usuario, $id_local);
        if ($model->fecha_publicacion !== null || $model->fecha_finalizacion !== null) {
            Yii::$app->session->setFlash('error', 'La vacante ya no puede ser editada');
            
            return $this->redirect(['view', 'id' => $model->id, 'id_usuario' => $model->id_usuario, 'id_local' => $model->id_local]);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'id_usuario' => $model->id_usuario, 'id_local' => $model->id_local]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Vacante model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $id_usuario
     * @param integer $id_local
     * @return mixed
     */
    /*  Posible reutilizacion con cambios o eliminacion
    public function actionDelete($id, $id_usuario, $id_local)
    {
        $this->findModel($id, $id_usuario, $id_local)->delete();

        return $this->redirect(['index']);
    }*/

    /**
     * Finds the Vacante model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $id_usuario
     * @param integer $id_local
     * @return Vacante the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $id_usuario, $id_local)
    {
        if (($model = Vacante::findOne(['id' => $id, 'id_usuario' => $id_usuario, 'id_local' => $id_local])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
