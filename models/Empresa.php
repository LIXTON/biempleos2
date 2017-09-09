<?php

namespace app\models;

use Yii;
//  Se utiliza para indicar quien creo o edito algo
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "empresa".
 *
 * @property integer $id_usuario
 * @property string $nombre
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
    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'id_usuario',
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
            ['nombre', 'required'],
            //[['id_usuario', 'nombre'], 'required'],
            //[['id_usuario'], 'integer'],
            [['nombre'], 'string', 'max' => 100],
            //[['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_usuario' => 'id']],
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
