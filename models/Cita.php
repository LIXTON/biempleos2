<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cita".
 *
 * @property integer $id
 * @property integer $id_empresa
 * @property integer $id_local
 * @property string $direccion
 * @property integer $id_va
 * @property string $fecha
 * @property string $mensaje
 *
 * @property Empresa $idEmpresa
 * @property Local $idLocal
 * @property VacanteAspirante $idVa
 */
class Cita extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cita';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_empresa', 'id_va', 'fecha', 'mensaje'], 'required'],
            [['id_empresa', 'id_local', 'id_va'], 'integer'],
            [['fecha'], 'safe'],
            [['mensaje'], 'string'],
            [['direccion'], 'string', 'max' => 255],
            [['id_empresa'], 'exist', 'skipOnError' => true, 'targetClass' => Empresa::className(), 'targetAttribute' => ['id_empresa' => 'id_usuario']],
            [['id_local'], 'exist', 'skipOnError' => true, 'targetClass' => Local::className(), 'targetAttribute' => ['id_local' => 'id']],
            [['id_va'], 'exist', 'skipOnError' => true, 'targetClass' => VacanteAspirante::className(), 'targetAttribute' => ['id_va' => 'id']],
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
            'id_local' => Yii::t('app', 'Id Local'),
            'direccion' => Yii::t('app', 'Direccion'),
            'id_va' => Yii::t('app', 'Id Va'),
            'fecha' => Yii::t('app', 'Fecha'),
            'mensaje' => Yii::t('app', 'Mensaje'),
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
    public function getIdLocal()
    {
        return $this->hasOne(Local::className(), ['id' => 'id_local']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdVa()
    {
        return $this->hasOne(VacanteAspirante::className(), ['id' => 'id_va']);
    }
}
