<?php

namespace app\controllers;

use Yii;
use app\models\Solicitud;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

// se agrego access control
use yii\filters\AccessControl;
// se agrego AccessRule
use app\components\AccessRule;

/**
 * SolicitudController implements the CRUD actions for Solicitud model.
 */
class SolicitudController extends Controller
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
                    /* 
                        existe un error que no encuentra app\components\AccessRule::className()
                        se modifico de la siguiente manera:
                    */
                    'class' => AccessRule::className(),
                    /*  
                        Sigue el error:
                            Getting unknown property: app\models\User::role
                    */
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create', 'update'],
                        'roles' => ['aspirante'],
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
     * Lists all Solicitud models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Solicitud::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Solicitud model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Solicitud model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Solicitud();
        $model->id_usuario = Yii::$app->user->id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_usuario]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Solicitud model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * Nota: se actualizo el metodo para poder editar y seleccionar la 
     * solicitud del usuario
     */
    public function actionUpdate(){
        $id_usuario = Yii::$app->user->id;
        $model = Solicitud::findOne($id_usuario);
        if(!$model){
            return $this->actionCreate();
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_usuario]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Solicitud model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    /*  Posible reutilizacion con cambios o eliminacion
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }*/

    /**
     * Finds the Solicitud model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Solicitud the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Solicitud::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
