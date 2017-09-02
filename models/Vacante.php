<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vacante".
 *
 * @property integer $id
 * @property integer $id_empresa
 * @property integer $id_local
 * @property string $puesto
 * @property string $sueldo
 * @property string $ofrece
 * @property string $requisito
 * @property string $horario
 * @property string $fecha_publicacion
 * @property string $fecha_finalizacion
 * @property integer $no_cita
 * @property string $fecha_expiracion
 *
 * @property Empresa $idEmpresa
 * @property Local $idLocal
 * @property VacanteAspirante[] $vacanteAspirantes
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
            [['id_empresa', 'id_local', 'puesto', 'requisito', 'horario', 'no_cita', 'fecha_expiracion'], 'required'],
            [['id_empresa', 'id_local', 'no_cita'], 'integer'],
            [['ofrece', 'requisito'], 'string'],
            [['fecha_publicacion', 'fecha_finalizacion', 'fecha_expiracion'], 'safe'],
            [['puesto'], 'string', 'max' => 255],
            [['sueldo', 'horario'], 'string', 'max' => 100],
            [['id_empresa'], 'exist', 'skipOnError' => true, 'targetClass' => Empresa::className(), 'targetAttribute' => ['id_empresa' => 'id_usuario']],
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
            'id_empresa' => Yii::t('app', 'Id Empresa'),
            'id_local' => Yii::t('app', 'Id Local'),
            'puesto' => Yii::t('app', 'Puesto'),
            'sueldo' => Yii::t('app', 'Sueldo'),
            'ofrece' => Yii::t('app', 'Ofrece'),
            'requisito' => Yii::t('app', 'Requisito'),
            'horario' => Yii::t('app', 'Horario'),
            'fecha_publicacion' => Yii::t('app', 'Fecha Publicacion'),
            'fecha_finalizacion' => Yii::t('app', 'Fecha Finalizacion'),
            'no_cita' => Yii::t('app', 'No Cita'),
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
}
