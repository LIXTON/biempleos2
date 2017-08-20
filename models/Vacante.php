<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vacante".
 *
 * @property integer $id
 * @property integer $id_usuario
 * @property integer $id_local
 * @property string $puesto
 * @property string $sueldo
 * @property string $ofrece
 * @property string $requisito
 * @property string $horario
 * @property string $fecha_publicacion
 * @property string $fecha_finalizacion
 *
 * @property Empresa $idUsuario
 * @property Local $idLocal
 * @property VacanteAspirante[] $vacanteAspirantes
 * @property Aspirante[] $idUsuarios
 */
class Vacante extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vacante';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_usuario', 'id_local', 'puesto', 'requisito', 'horario'], 'required'],
            [['id_usuario', 'id_local'], 'integer'],
            [['ofrece', 'requisito'], 'string'],
            [['fecha_publicacion', 'fecha_finalizacion'], 'safe'],
            [['puesto'], 'string', 'max' => 255],
            [['sueldo', 'horario'], 'string', 'max' => 100],
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
            'puesto' => Yii::t('app', 'Puesto'),
            'sueldo' => Yii::t('app', 'Sueldo'),
            'ofrece' => Yii::t('app', 'Ofrece'),
            'requisito' => Yii::t('app', 'Requisito'),
            'horario' => Yii::t('app', 'Horario'),
            'fecha_publicacion' => Yii::t('app', 'Fecha Publicacion'),
            'fecha_finalizacion' => Yii::t('app', 'Fecha Finalizacion'),
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVacanteAspirantes()
    {
        return $this->hasMany(VacanteAspirante::className(), ['id_vacante' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUsuarios()
    {
        return $this->hasMany(Aspirante::className(), ['id_usuario' => 'id_usuario'])->viaTable('vacante_aspirante', ['id_vacante' => 'id']);
    }
}
