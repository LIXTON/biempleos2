<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "oferta".
 *
 * @property integer $id
 * @property integer $id_paquete
 * @property string $descuento
 * @property integer $paquete_padre
 *
 * @property Paquete $idPaquete
 * @property Paquete $paquetePadre
 */
class Oferta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'oferta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_paquete', 'descuento'], 'required'],
            [['id_paquete', 'paquete_padre'], 'integer'],
            [['descuento'], 'string', 'max' => 20],
            [['id_paquete'], 'exist', 'skipOnError' => true, 'targetClass' => Paquete::className(), 'targetAttribute' => ['id_paquete' => 'id']],
            [['paquete_padre'], 'exist', 'skipOnError' => true, 'targetClass' => Paquete::className(), 'targetAttribute' => ['paquete_padre' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_paquete' => Yii::t('app', 'Id Paquete'),
            'descuento' => Yii::t('app', 'Descuento'),
            'paquete_padre' => Yii::t('app', 'Paquete Padre'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPaquete()
    {
        return $this->hasOne(Paquete::className(), ['id' => 'id_paquete']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaquetePadre()
    {
        return $this->hasOne(Paquete::className(), ['id' => 'paquete_padre']);
    }
}
