<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "local".
 *
 * @property integer $id
 * @property integer $id_usuario
 * @property string $calle
 * @property integer $numero
 * @property string $colonia
 * @property integer $codigo_postal
 * @property string $pais
 * @property string $estado
 * @property string $ciudad
 * @property integer $activo
 *
 * @property Cita[] $citas
 * @property Empresa $idUsuario
 * @property Vacante[] $vacantes
 */
class Local extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'local';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_usuario', 'calle', 'numero', 'colonia', 'codigo_postal', 'pais', 'estado', 'ciudad', 'activo'], 'required'],
            [['id_usuario', 'numero', 'codigo_postal', 'activo'], 'integer'],
            [['calle', 'colonia', 'pais', 'estado', 'ciudad'], 'string', 'max' => 100],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Empresa::className(), 'targetAttribute' => ['id_usuario' => 'id_usuario']],
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
            'calle' => Yii::t('app', 'Calle'),
            'numero' => Yii::t('app', 'Numero'),
            'colonia' => Yii::t('app', 'Colonia'),
            'codigo_postal' => Yii::t('app', 'Codigo Postal'),
            'pais' => Yii::t('app', 'Pais'),
            'estado' => Yii::t('app', 'Estado'),
            'ciudad' => Yii::t('app', 'Ciudad'),
            'activo' => Yii::t('app', 'Activo'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCitas()
    {
        return $this->hasMany(Cita::className(), ['id_local' => 'id']);
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
    public function getVacantes()
    {
        return $this->hasMany(Vacante::className(), ['id_local' => 'id']);
    }
}
