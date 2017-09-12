<?php

namespace app\models;

use Yii;
//  Se utiliza para indicar que empresa la creo o la edito
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "local".
 *
 * @property integer $id
 * @property integer $id_empresa
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
 * @property Empresa $idEmpresa
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
            [['calle', 'numero', 'colonia', 'codigo_postal', 'pais', 'estado', 'ciudad', 'activo'], 'required'],
            [['numero', 'codigo_postal', 'activo'], 'integer'],
            [['calle', 'colonia', 'pais', 'estado', 'ciudad'], 'string', 'max' => 100],
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
    public function getIdEmpresa()
    {
        return $this->hasOne(Empresa::className(), ['id_usuario' => 'id_empresa']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVacantes()
    {
        return $this->hasMany(Vacante::className(), ['id_local' => 'id']);
    }
}
