<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "aspirante".
 *
 * @property integer $id_usuario
 * @property string $gcm
 * @property integer $activo
 *
 * @property Usuario $idUsuario
 * @property Solicitud $solicitud
 * @property VacanteAspirante[] $vacanteAspirantes
 */
class Aspirante extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'aspirante';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_usuario', 'gcm'], 'required'],
            [['id_usuario', 'activo'], 'integer'],
            [['gcm'], 'string', 'max' => 100],
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
            'gcm' => Yii::t('app', 'Gcm'),
            'activo' => Yii::t('app', 'Activo'),
        ];
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
    public function getSolicitud()
    {
        return $this->hasOne(Solicitud::className(), ['id_aspirante' => 'id_usuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVacanteAspirantes()
    {
        return $this->hasMany(VacanteAspirante::className(), ['id_aspirante' => 'id_usuario']);
    }
}
