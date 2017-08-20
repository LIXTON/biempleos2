<?php

namespace app\controllers;

use Yii;
use app\models\VacanteAspirante;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
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
        $dataProvider = new ActiveDataProvider([
            'query' => VacanteAspirante::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VacanteAspirante model.
     * @param integer $id_usuario
     * @param integer $id_vacante
     * @return mixed
     */
    public function actionView($id_usuario, $id_vacante)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_usuario, $id_vacante),
        ]);
    }

    /**
     * Creates a new VacanteAspirante model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new VacanteAspirante();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_usuario' => $model->id_usuario, 'id_vacante' => $model->id_vacante]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing VacanteAspirante model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id_usuario
     * @param integer $id_vacante
     * @return mixed
     */
    public function actionUpdate($id_usuario, $id_vacante)
    {
        $model = $this->findModel($id_usuario, $id_vacante);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_usuario' => $model->id_usuario, 'id_vacante' => $model->id_vacante]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing VacanteAspirante model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id_usuario
     * @param integer $id_vacante
     * @return mixed
     */
    public function actionDelete($id_usuario, $id_vacante)
    {
        $this->findModel($id_usuario, $id_vacante)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the VacanteAspirante model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id_usuario
     * @param integer $id_vacante
     * @return VacanteAspirante the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_usuario, $id_vacante)
    {
        if (($model = VacanteAspirante::findOne(['id_usuario' => $id_usuario, 'id_vacante' => $id_vacante])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
