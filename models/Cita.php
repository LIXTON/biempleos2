<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cita".
 *
 * @property integer $id
 * @property integer $id_usuario
 * @property integer $id_local
 * @property string $fecha
 * @property string $mensaje
 *
 * @property Empresa $idUsuario
 * @property Local $idLocal
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
            [['id_usuario', 'fecha', 'mensaje'], 'required'],
            [['id_usuario', 'id_local'], 'integer'],
            [['fecha'], 'safe'],
            [['mensaje'], 'string'],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Empresa::className(), 'targetAttribute' => ['id_usuario' => 'id_usuario']],
            [['id_local'], 'exist', 'skipOnError' => true, 'targetClass' => Local::className(), 'targetAttribute' => ['id_local' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_usuario' => Yii::t('app', 'Id Usuario'),
            'id_local' => Yii::t('app', 'Id Local'),
            'fecha' => Yii::t('app', 'Fecha'),
            'mensaje' => Yii::t('app', 'Mensaje'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUsuario()
    {
        return $this->hasOne(Empresa::className(), ['id_usuario' => 'id_usuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdLocal()
    {
        return $this->hasOne(Local::className(), ['id' => 'id_local']);
    }
}
