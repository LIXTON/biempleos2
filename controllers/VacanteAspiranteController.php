<?php

namespace app\controllers;

use Yii;
use app\models\VacanteAspirante;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
//  Las siguientes dos lineas son para el funcionamiento de los roles   //
use yii\filters\AccessControl;
use app\components\AccessRule;
//  Se utiliza en caso de errores de datos introducidos o bien          //
//  alteracion de datos                                                 //
use yii\web\BadRequestHttpException;

/**
 * VacanteAspiranteController implements the CRUD actions for VacanteAspirante model.
 */
class VacanteAspiranteController extends Controller
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
                        'actions' => ['create'],
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
     * Lists all VacanteAspirante models.
     * @return mixed
     */
    public function actionIndex()
    {
        $query = (new \yii\db\Query());
        //  Empresa:
        //  El query devuelve todos los aspirantes que aplicaron a la vacante
        //
        //  Aspirante:
        //  El query devuelve todas las vacantes que aplico y que siguen activas
        switch(Yii::$app->user->identity->rol) {
            case "empresa":
                if (!Yii::$app->request->get('id_vacante'))
                    throw new BadRequestHttpException('ID Vacante is required in the url');
                
                $query = $query->select([
                    'id' => 'vacante_aspirante.id',
                    'id_aspirante' => 'vacante_aspirante.id_aspirante',
                    'aspirante' => 'solicitud.nombre',
                    'fecha' => 'vacante_aspirante.fecha_cambio_estado'
                ])
                    ->from('vacante_aspirante')
                    ->innerJoin('aspirante', 'aspirante.id_usuario = vacante_aspirante.id_aspirante')
                    ->innerJoin('solicitud', 'solicitud.id_aspirante = aspirante.id_usuario')
                    ->where('vacante_aspirante.estado = :estado AND vacante_aspirante.id_vacante = :vacante', [':estado' => 'pendiente', ':vacante' => Yii::$app->request->get('id_vacante')]);
                break;
            case "aspirante":
                //  Es posible que esto truene
                $query = $query->select([
                    'id' => 'vacante_aspirante.id',
                    'id_vacante' => 'vacante.id',
                    'puesto' => 'vacante.puesto',
                    'estado' => 'vacante_aspirante.estado',
                    'fecha' => 'vacante_aspirante.fecha_cambio_estado'
                ])
                    ->innerJoin('vacante', 'vacante.id = vacante_aspirante.id_vacante')
                    ->where('vacante_aspirante.id_aspirante = :aspirante AND vacante.fecha_finalizacion >= :fecha', [':aspirante' => Yii::$app->user->id, ':fecha' => date("Y-m-d")]);
                break;
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        print_r($dataProvider->getKeys());
        die();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VacanteAspirante model.
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
     * Creates a new VacanteAspirante model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new VacanteAspirante();//['scenario' => VacanteAspirante::SCENARIO_CREATE]);

        $model->id_vacante = Yii::$app->request->post('id');

        if ($model->save()) {
            return $this->redirect(['index']);
        }
        
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing VacanteAspirante model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    /*  Posible reutilizacion con cambios o eliminacion
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }*/

    /**
     * Deletes an existing VacanteAspirante model.
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
     * Finds the VacanteAspirante model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VacanteAspirante the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VacanteAspirante::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
