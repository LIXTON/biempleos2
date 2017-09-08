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
//  Las siguientes dos lineas son para el funcionamiento de los roles   //
use yii\filters\AccessControl;
use app\components\AccessRule;

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
                        'actions' => ['create', 'update'],
                        'roles' => ['empresa'],
                        'matchCallback' => function($rule, $action) {
                            return !Yii::$app->request->get('id') || Yii::$app->request->get('id') == Yii::$app->user->id;
                        }
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'view'],
                        'roles' => ['@'],
                        'matchCallback' => function($rule, $action) {
                            return !Yii::$app->request->get('id') || Yii::$app->request->get('id') == Yii::$app->user->id;
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
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
     * Action clonada para no modificar el index y no afectar otro tipo de funciones empresariales
     * @return mixed
     */
    public function actionVervacantes()
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
        $model = new Vacante();
        $ep = EmpresaPaquete::findOne(Yii::$app->user->id);

        if ($model->load(Yii::$app->request->post()) && $this->isAvaliable($ep)) {
            $ep->no_vacante -= 1;
            $ep->save();
            $model->save();
            return $this->redirect(['view', 'id' => $model->id, 'id_empresa' => $model->id_empresa, 'id_local' => $model->id_local]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Vacante model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $id_empresa
     * @param integer $id_local
     * @return mixed
     */
    public function actionUpdate($id, $id_empresa, $id_local)
    {
        $model = $this->findModel($id, $id_empresa, $id_local);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'id_empresa' => $model->id_empresa, 'id_local' => $model->id_local]);
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
     * @param integer $id_empresa
     * @param integer $id_local
     * @return mixed
     */
    public function actionDelete($id, $id_empresa, $id_local)
    {
        $this->findModel($id, $id_empresa, $id_local)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Vacante model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $id_empresa
     * @param integer $id_local
     * @return Vacante the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $id_empresa, $id_local)
    {
        if (($model = Vacante::findOne(['id' => $id, 'id_empresa' => $id_empresa, 'id_local' => $id_local])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function isAvaliable($ep) {
        return $ep->fecha_expiracion > date('Y-m-d') && $ep->no_vacante > 0;
    }
}
