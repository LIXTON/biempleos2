<?php

namespace app\models;

use Yii;
//  Se utiliza para indicar que empresa la creo o la edito
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "empresa_paquete".
 *
 * @property integer $id
 * @property integer $id_empresa
 * @property integer $id_paquete
 * @property integer $no_vacante
 * @property string $fecha_expiracion
 *
 * @property Empresa $idEmpresa
 * @property Paquete $idPaquete
 */
class EmpresaPaquete extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'empresa_paquete';
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'id_empresa',
                'updatedByAttribute' => false,
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_paquete', 'no_vacante', 'fecha_expiracion'], 'required', 'message' => Yii::t('app', 'El campo no puede estar vacio')],
            [['id_empresa', 'id_paquete', 'no_vacante'], 'integer'],
            [['fecha_expiracion'], 'safe'],
            [['id_paquete'], 'exist', 'skipOnError' => true, 'targetClass' => Paquete::className(), 'targetAttribute' => ['id_paquete' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_empresa' => Yii::t('app', 'Id Empresa'),
            'id_paquete' => Yii::t('app', 'Id Paquete'),
            'no_vacante' => Yii::t('app', 'No Vacante'),
            'fecha_expiracion' => Yii::t('app', 'Fecha Expiracion'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEmpresa()
    {
        return $this->hasOne(Empresa::className(), ['id_usuario' => 'id_empresa']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPaquete()
    {
        return $this->hasOne(Paquete::className(), ['id' => 'id_paquete']);
    }
}
