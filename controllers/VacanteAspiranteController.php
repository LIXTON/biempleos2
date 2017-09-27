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
//  Se usa lo siguiente para el pdf                                     //
use app\models\Solicitud;
use app\models\Vacante;
use app\components\SolicitudPDF;

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
                        'actions' => ['create', 'indexmovil'],
                        'roles' => ['aspirante'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'view-aspirante'],
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
     * Lists all VacanteAspirante models.
     * @return mixed
     */
    public function actionIndex()
    {
        /*
        SELECT solicitud.nombre, vacante_aspirante.fecha_cambio_estado
FROM aspirante
INNER JOIN solicitud ON solicitud.id_aspirante = aspirante.id_usuario
INNER JOIN vacante_aspirante ON vacante_aspirante.id_aspirante = aspirante.id_usuario
INNER JOIN vacante ON vacante_aspirante.id_vacante = vacante.id
WHERE vacante.fecha_publicacion IS NOT NULL
AND vacante.fecha_finalizacion <= hoy
AND vacante.id_empresa = 2
AND vacante_aspirante.estado = 'pendiente';
        */
        $query = (new \yii\db\Query())->select([
            'id' => 'vacante_aspirante.id',
            'aspirante' => 'solicitud.nombre',
            'fecha' => 'vacante_aspirante.fecha_cambio_estado'
        ])
            ->from('aspirante')
            ->innerJoin('solicitud', 'solicitud.id_aspirante = aspirante.id_usuario')
            ->innerJoin('vacante_aspirante', 'vacante_aspirante.id_aspirante = aspirante.id_usuario')
            ->innerJoin('vacante', 'vacante.id = vacante_aspirante.id_vacante')
            ->where('vacante_aspirante.estado = :estado', [':estado' => 'pendiente'])
            ->andWhere('vacante.fecha_publicacion IS NOT NULL')
            ->andWhere('vacante.fecha_finalizacion >= :fecha', [':fecha' => date('Y-m-d')])
            ->andWhere('vacante.id_empresa = :empresa', [':empresa' => Yii::$app->user->id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Otra action que se creo para visualizar notificaciones de los aspirantes
     * @return mixed
     */
    public function actionIndexmovil(){
        $dataProvider = new ActiveDataProvider([
            'query' => VacanteAspirante::find(["id_aspirante"=> Yii::$app->user->id]),
        ]);

        return $this->render('indexmovil', [
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
     * Displays a single VacanteAspirante model.
     * @param integer $id
     * @return mixed
     */
    public function actionViewAspirante($id)
    {
        $va = $this->findModel($id);
        return $this->render('view', [
            'model' => $va,
            'solicitud' => Solicitud::findOne(['id_aspirante' => $va->id_aspirante]),
        ]);
    }

    /**
     * Creates a new VacanteAspirante model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new VacanteAspirante(['scenario' => VacanteAspirante::SCENARIO_CREATE]);

        $model->id_vacante = Yii::$app->request->post('id');

        if ($model->save()) {
            return $this->redirect(['indexmovil']);
        }
        
        return $this->render('create', [
            'model' => $model,
        ]);
    }
    
    /**
     * Creates a new VacanteAspirante model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionDescargar($id)
    {
        $va = $this->findModel($id);
        $vacante = Vacante::findOne($va->id_vacante);
        $solicitud = Solicitud::findOne(['id_aspirante' => $va->id_aspirante]);
        
        $pdf = new SolicitudPDF($vacante, $solicitud);
        $pdf->getPDFAspirante();
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
