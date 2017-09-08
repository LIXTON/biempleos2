<?php

namespace app\controllers;

use Yii;
use app\models\Empresa;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
//  Las siguientes dos lineas son para el funcionamiento de los roles   //
use yii\filters\AccessControl;
use app\components\AccessRule;

/**
 * EmpresaController implements the CRUD actions for Empresa model.
 */
class EmpresaController extends Controller
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
                        'roles' => ['empresa'],
                        'matchCallback' => function($rule, $action) {
                            return !Yii::$app->request->get('id') || Yii::$app->request->get('id') == Yii::$app->user->id;
                        }
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
     * Lists all Empresa models.
     * @return mixed
     */
    /*  Posible reutilizacion con cambios o eliminacion*/
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Empresa::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Empresa model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'empresa' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Empresa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    /*public function actionCreate()
    {
        $empresa = new Empresa();

        if ($empresa->load(Yii::$app->request->post()) && $empresa->save()) {
            return $this->redirect(['view', 'id' => $empresa->id_usuario]);
        } else {
            return $this->render('create', [
                'empresa' => $empresa,
            ]);
        }
    }*/

    /**
     * Updates an existing Empresa model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
    /*  Posible reutilizacion con cambios o eliminacion
    public function actionUpdate($id)
    {
        $empresa = $this->findModel($id);
        
        if ($empresa->load(Yii::$app->request->post()) && $empresa->save()) {
            return $this->redirect(['view', 'id' => $empresa->id_usuario]);
        }
        
        return $this->render('update', [
            'empresa' => $empresa,
        ]);
    }*/

    /**
     * Deletes an existing Empresa model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    /*public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }*/

    /**
     * Finds the Empresa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Empresa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($empresa = Empresa::findOne($id)) !== null) {
            return $empresa;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
