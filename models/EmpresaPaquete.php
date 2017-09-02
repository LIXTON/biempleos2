<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "empresa_paquete".
 *
 * @property integer $id
 * @property integer $id_empresa
 * @property integer $no_vacante
 *
 * @property Empresa $idEmpresa
 */
class EmpresaPaquete extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'empresa_paquete';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_empresa', 'no_vacante'], 'required'],
            [['id_empresa', 'no_vacante'], 'integer'],
            [['id_empresa'], 'exist', 'skipOnError' => true, 'targetClass' => Empresa::className(), 'targetAttribute' => ['id_empresa' => 'id_usuario']],
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
            'no_vacante' => Yii::t('app', 'No Vacante'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEmpresa()
    {
        return $this->hasOne(Empresa::className(), ['id_usuario' => 'id_empresa']);
    }
}
