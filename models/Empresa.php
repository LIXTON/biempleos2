<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "empresa".
 *
 * @property integer $id_usuario
 * @property string $nombre
 * @property string $fecha_expiracion
 *
 * @property Cita[] $citas
 * @property Usuario $idUsuario
 * @property EmpresaPaquete[] $empresaPaquetes
 * @property Local[] $locals
 * @property Vacante[] $vacantes
 */
class Empresa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'empresa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_usuario', 'nombre'], 'required'],
            [['id_usuario'], 'integer'],
            [['fecha_expiracion'], 'safe'],
            [['nombre'], 'string', 'max' => 100],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_usuario' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_usuario' => Yii::t('app', 'Id Usuario'),
            'nombre' => Yii::t('app', 'Nombre'),
            'fecha_expiracion' => Yii::t('app', 'Fecha Expiracion'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCitas()
    {
        return $this->hasMany(Cita::className(), ['id_empresa' => 'id_usuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUsuario()
    {
        return $this->hasOne(User::className(), ['id' => 'id_usuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresaPaquetes()
    {
        return $this->hasMany(EmpresaPaquete::className(), ['id_empresa' => 'id_usuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocals()
    {
        return $this->hasMany(Local::className(), ['id_empresa' => 'id_usuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVacantes()
    {
        return $this->hasMany(Vacante::className(), ['id_empresa' => 'id_usuario']);
    }
}
