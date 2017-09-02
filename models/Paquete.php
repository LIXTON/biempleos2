<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "paquete".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $descripcion
 * @property integer $no_vacante
 * @property integer $no_cita
 * @property string $duracion
 * @property double $precio
 *
 * @property Oferta $oferta
 * @property Oferta[] $ofertas
 */
class Paquete extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'paquete';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'no_vacante', 'no_cita', 'precio'], 'required'],
            [['descripcion'], 'string'],
            [['no_vacante', 'no_cita'], 'integer'],
            [['precio'], 'number'],
            [['nombre'], 'string', 'max' => 255],
            [['duracion'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nombre' => Yii::t('app', 'Nombre'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'no_vacante' => Yii::t('app', 'No Vacante'),
            'no_cita' => Yii::t('app', 'No Cita'),
            'duracion' => Yii::t('app', 'Duracion'),
            'precio' => Yii::t('app', 'Precio'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOferta()
    {
        return $this->hasOne(Oferta::className(), ['id_paquete' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOfertas()
    {
        return $this->hasMany(Oferta::className(), ['paquete_padre' => 'id']);
    }
}
