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
    public function actionView($id, $id_empresa)
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
        $local = Local::findAll(['id_empresa' => Yii::$app->user->id]);
        $v = VacanteAspirante::findAll(['id_vacante' => $id_v]);
        $aspirantes = array();
        foreach($v as $i)
            array_push($aspirantes, $i->idAspirante);

        if ($cita->load(Yii::$app->request->post())) {
            $cita->id_va = $v[0]->id;
            $cita->save();
            return $this->redirect(['view', 'id' => $cita->id, 'id_empresa' => $cita->id_empresa]);
        }

        return $this->render('create', [
            'model' => $cita,
        ]);
    }

    /**
     * Updates an existing Cita model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $id_empresa
     * @return mixed
     */
    public function actionUpdate($id, $id_empresa)
    {
        $model = $this->findModel($id, $id_empresa);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'id_empresa' => $model->id_empresa]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
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
    protected function findModel($id, $id_empresa)
    {
        $id_empresa = Yii::$app->user->identity->rol == "empresa" ? Yii::$app->user->id:$id_empresa;
        if (($model = Cita::findOne(['id' => $id, 'id_empresa' => $id_empresa])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
