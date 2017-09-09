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
                        'actions' => ['index-empresa', 'create', 'update'],
                        'roles' => ['empresa'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index-aspirante'],
                        'roles' => ['aspirante'],
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
     * Solo se visualiza para aspirantes
     * @return mixed
     */
    public function actionIndexAspirante()
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
    public function actionIndexEmpresa()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Vacante::find()->where(['id_empresa' => Yii::$app->user->id]),
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
        //  Restringe la vista de vacantes a empresas
        $id_empresa = Yii::$app->user->identity->rol == 'empresa' ? Yii::$app->user->id:$id_empresa;
        $vacante = $this->findModel($id, $id_empresa, $id_local);
        
        if($vacante === null) {
            Yii::$app->session->setFlash('error', 'No tienes acceso a la vacante');
            switch(Yii::$app->user->identity->rol) {
                case "aspirante":
                    return $this->redirect(['index-aspirante']);
                case "empresa":
                    return $this->redirect(['index-empresa']);
            }
        }
        
        return $this->render('view', [
            'model' => $vacante,
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
        $ep = EmpresaPaquete::findAll(['id_empresa' => Yii::$app->user->id]);
        $local = Local::findAll(['id_empresa' => Yii::$app->user->id]);

        if ($model->load(Yii::$app->request->post()) && $ep->load(Yii::$app->request->post())) {
            if($ep->fecha_expiracion > date('Y-m-d') && $ep->no_vacante > 0) {
                $ep->no_vacante -= 1;
                $ep->save();
                $model->fecha_expiracion = $ep->fecha_expiracion;
                $model->save();
                return $this->redirect(['view', 'id' => $model->id, 'id_local' => $model->id_local]);
            }
        }
        
        return $this->render('create', [
            'model' => $model,
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
        $model = $this->findModel($id, Yii::$app->user->id, $id_local);
        $msgError = null;
        
        if ($isUnavaliable = $model->fecha_expiracion < date('Y-m-d'))
            $msgError = "La vacante no puede ser editada debido a que expiro el paquete.";
        else if ($isUnavaliable = !empty($model->fecha_finalizacion))
            $msgError = "La vacante no puede ser editada debido a que la contratacion finalizo.";
        else if ($isUnavaliable = !empty($model->fecha_publicacion))
            $msgError = "La vacante no puede ser editada debido a que fue publicada.";
        
        if($isUnavaliable)
            return $this->redirect(['index-empresa']);

        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            return $this->redirect(['view', 'id' => $model->id, 'id_empresa' => $model->id_empresa, 'id_local' => $model->id_local]);
        }
        
        return $this->render('update', [
            'model' => $model,
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
}
