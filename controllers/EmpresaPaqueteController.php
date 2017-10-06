<?php

namespace app\controllers;

use Yii;
use app\models\EmpresaPaquete;
use app\models\Paquete;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
//  Las siguientes dos lineas son para el funcionamiento de los roles   //
use yii\filters\AccessControl;
use app\components\AccessRule;

use app\components\Paypal;

/**
 * PaqueteController implements the CRUD actions for Paquete model.
 */
class PaqueteController extends Controller
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
                        'actions' => ['contratar', 'confirmar-pago'],
                        'roles' => ['empresa'],
                    ],
                ],
            ],
        ];
    }

    public function actionContratar($paquete) {
        Paypal::checkout($paquete);
    }
    
    public function actionConfirmarPago($status) {
        if ($status && Paypal::process($_GET['paymentId'], $_GET['PayerID'])) {
            Yii::$app->session->setFlash('success', 'El paquete se ha activado');
            
            $paquete = Paquete::findOne($paquete);
            $empresaPaquete = new EmpresaPaquete();
            $empresaPaquete->id_paquete = $paquete->id;
            $empresaPaquete->no_vacante = $paquete->no_vacante;
            
            $fechaExpiracion = explode(" ", strtolower($paquete->duracion));
            $fechaFinal = array('+');
            foreach($fechaExpiracion as $f) {
                if (is_numeric($f)) {
                    array_push($fechaFinal, $f);
                } else {
                    switch($f) {
                        case "meses":
                            $f = "months";
                            break;

                        case "mes":
                            $f = "months";
                            break;

                        case "dias":
                        case "días":
                            $f = "days";
                            break;

                        case "dia":
                        case "día":
                            $f = "day";
                            break;
                    }
                    array_push($fechaFinal, " " . $f. " ");
                }
            }
            
            $fechaExpiracion = implode($fechaFinal);
            
            $empresaPaquete->fecha_expiracion = date('Y-m-d', strtotime($fechaExpiracion));
            $empresaPaquete->save();
        } else {
            Yii::$app->session->setFlash('error', 'El pago no se realizo');
        }
        
        return $this->render('confirmar-pago');
    }

    /**
     * Finds the EmpresaPaquete model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Paquete the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EmpresaPaquete::findOne(['id' => $id, 'id_empresa' => Yii::$app->user->id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}