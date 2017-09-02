<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vacante_aspirante".
 *
 * @property integer $id
 * @property integer $id_aspirante
 * @property integer $id_vacante
 * @property string $estado
 * @property string $fecha_cambio_estado
 *
 * @property Cita[] $citas
 * @property Aspirante $idAspirante
 * @property Vacante $idVacante
 */
class VacanteAspirante extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vacante_aspirante';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_aspirante', 'id_vacante', 'estado'], 'required'],
            [['id', 'id_aspirante', 'id_vacante'], 'integer'],
            [['fecha_cambio_estado'], 'safe'],
            [['estado'], 'string', 'max' => 20],
            [['id_aspirante'], 'exist', 'skipOnError' => true, 'targetClass' => Aspirante::className(), 'targetAttribute' => ['id_aspirante' => 'id_usuario']],
            [['id_vacante'], 'exist', 'skipOnError' => true, 'targetClass' => Vacante::className(), 'targetAttribute' => ['id_vacante' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_aspirante' => Yii::t('app', 'Id Aspirante'),
            'id_vacante' => Yii::t('app', 'Id Vacante'),
            'estado' => Yii::t('app', 'Estado'),
            'fecha_cambio_estado' => Yii::t('app', 'Fecha Cambio Estado'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCitas()
    {
        return $this->hasMany(Cita::className(), ['id_va' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAspirante()
    {
        return $this->hasOne(Aspirante::className(), ['id_usuario' => 'id_aspirante']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdVacante()
    {
        return $this->hasOne(Vacante::className(), ['id' => 'id_vacante']);
    }
}
