<?php

namespace app\controllers;

use Yii;
use app\models\Cita;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
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
     * @param integer $id_usuario
     * @return mixed
     */
    public function actionView($id, $id_usuario)
    {
        return $this->render('view', [
            'model' => $this->findModel($id, $id_usuario),
        ]);
    }

    /**
     * Creates a new Cita model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Cita();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'id_usuario' => $model->id_usuario]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Cita model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $id_usuario
     * @return mixed
     */
    public function actionUpdate($id, $id_usuario)
    {
        $model = $this->findModel($id, $id_usuario);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'id_usuario' => $model->id_usuario]);
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
     * @param integer $id_usuario
     * @return mixed
     */
    public function actionDelete($id, $id_usuario)
    {
        $this->findModel($id, $id_usuario)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Cita model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $id_usuario
     * @return Cita the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $id_usuario)
    {
        if (($model = Cita::findOne(['id' => $id, 'id_usuario' => $id_usuario])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}