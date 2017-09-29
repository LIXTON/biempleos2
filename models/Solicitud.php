<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "solicitud".
 *
 * @property integer $id_aspirante
 * @property string $foto
 * @property string $nombre
 * @property string $fecha_nacimiento
 * @property string $sexo
 * @property string $nacionalidad
 * @property double $estatura
 * @property double $peso
 * @property string $estado_civil
 * @property string $calle
 * @property string $numero
 * @property string $colonia
 * @property string $codigo_postal
 * @property string $lugar_residencia
 * @property string $lugar_nacimiento
 * @property string $vive_con
 * @property string $curp
 * @property string $rfc
 * @property string $nss
 * @property string $afore
 * @property string $cartilla_militar
 * @property string $pasaporte
 * @property string $clase_licencia
 * @property string $numero_licencia
 * @property string $deporte
 * @property string $club
 * @property string $pasatiempo
 * @property string $meta
 * @property integer $padre_vivefin
 * @property string $padre_domicilio
 * @property string $padre_ocupacion
 * @property integer $madre_vivefin
 * @property string $madre_domicilio
 * @property string $madre_ocupacion
 * @property integer $pareja_vivefin
 * @property string $pareja_domicilio
 * @property string $pareja_ocupacion
 * @property string $hijos
 * @property string $estudio
 * @property string $escuela
 * @property string $inicio
 * @property string $finalizacion
 * @property string $titulo
 * @property string $idioma
 * @property string $funciones_oficina
 * @property string $maquinaria_oficina
 * @property string $software
 * @property string $otras_funciones
 * @property integer $tiempo_trabajo
 * @property string $compania
 * @property string $direccion
 * @property string $telefono
 * @property string $puesto
 * @property double $sueldo_inicial
 * @property double $sueldo_final
 * @property string $motivo_separacion
 * @property string $nombre_jefe
 * @property string $puesto_jefe
 * @property integer $solicitud_informe
 * @property string $nombre_ref1
 * @property string $domicilio_ref1
 * @property string $telefono_ref1
 * @property string $ocupacion_ref1
 * @property double $tiempo_ref1
 * @property string $nombre_ref2
 * @property string $domicilio_ref2
 * @property string $telefono_ref2
 * @property string $ocupacion_ref2
 * @property double $tiempo_ref2
 * @property string $nombre_ref3
 * @property string $domicilio_ref3
 * @property string $telefono_ref3
 * @property string $ocupacion_ref3
 * @property double $tiempo_ref3
 * @property integer $afianzado
 * @property integer $sindicato
 * @property integer $seguro_vida
 * @property integer $viajar
 * @property integer $cambiar_residencia
 * @property integer $otros_ingresos
 * @property double $importe_ingresos
 * @property integer $conyuge_trabaja
 * @property double $percepcion
 * @property integer $casa_propia
 * @property double $valor_casa
 * @property integer $paga_renta
 * @property double $renta
 * @property string $dependientes
 * @property integer $automovil
 * @property integer $deudas
 * @property double $importe_deudas
 * @property string $acreedor
 * @property double $abono_mensual
 * @property double $gastos_mensuales
 *
 * @property Aspirante $idAspirante
 */
class Solicitud extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'solicitud';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_aspirante'], 'required'],
            [['id_aspirante', 'padre_vivefin', 'madre_vivefin', 'pareja_vivefin', 'tiempo_trabajo', 'solicitud_informe', 'afianzado', 'sindicato', 'seguro_vida', 'viajar', 'cambiar_residencia', 'otros_ingresos', 'conyuge_trabaja', 'casa_propia', 'paga_renta', 'automovil', 'deudas'], 'integer'],
            [['foto', 'nombre', 'nacionalidad', 'calle', 'numero', 'colonia', 'codigo_postal', 'curp', 'rfc', 'nss', 'afore', 'cartilla_militar', 'pasaporte', 'numero_licencia', 'deporte', 'pasatiempo', 'meta', 'escuela', 'idioma', 'funciones_oficina', 'maquinaria_oficina', 'software', 'otras_funciones', 'compania', 'direccion', 'telefono', 'puesto', 'motivo_separacion', 'nombre_jefe', 'puesto_jefe', 'nombre_ref1', 'domicilio_ref1', 'telefono_ref1', 'ocupacion_ref1', 'nombre_ref2', 'domicilio_ref2', 'telefono_ref2', 'ocupacion_ref2', 'nombre_ref3', 'domicilio_ref3', 'telefono_ref3', 'ocupacion_ref3', 'acreedor'], 'string'],
            [['fecha_nacimiento', 'inicio', 'finalizacion'], 'safe'],
            [['estatura', 'peso', 'sueldo_inicial', 'sueldo_final', 'tiempo_ref1', 'tiempo_ref2', 'tiempo_ref3', 'importe_ingresos', 'percepcion', 'valor_casa', 'renta', 'importe_deudas', 'abono_mensual', 'gastos_mensuales'], 'number'],
            [['sexo'], 'string', 'max' => 15],
            [['estado_civil'], 'string', 'max' => 20],
            [['lugar_residencia', 'lugar_nacimiento', 'club', 'padre_domicilio', 'padre_ocupacion', 'madre_domicilio', 'madre_ocupacion', 'pareja_domicilio', 'pareja_ocupacion', 'hijos', 'titulo'], 'string', 'max' => 255],
            [['vive_con', 'dependientes'], 'string', 'max' => 40],
            [['clase_licencia', 'estudio'], 'string', 'max' => 100],
            [['id_aspirante'], 'exist', 'skipOnError' => true, 'targetClass' => Aspirante::className(), 'targetAttribute' => ['id_aspirante' => 'id_usuario']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_aspirante' => Yii::t('app', 'Id Aspirante'),
            'foto' => Yii::t('app', 'Foto'),
            'nombre' => Yii::t('app', 'Nombre'),
            'fecha_nacimiento' => Yii::t('app', 'Fecha Nacimiento'),
            'sexo' => Yii::t('app', 'Sexo'),
            'nacionalidad' => Yii::t('app', 'Nacionalidad'),
            'estatura' => Yii::t('app', 'Estatura'),
            'peso' => Yii::t('app', 'Peso'),
            'estado_civil' => Yii::t('app', 'Estado Civil'),
            'calle' => Yii::t('app', 'Calle'),
            'numero' => Yii::t('app', 'Numero'),
            'colonia' => Yii::t('app', 'Colonia'),
            'codigo_postal' => Yii::t('app', 'Codigo Postal'),
            'lugar_residencia' => Yii::t('app', 'Lugar Residencia'),
            'lugar_nacimiento' => Yii::t('app', 'Lugar Nacimiento'),
            'vive_con' => Yii::t('app', 'Vive Con'),
            'curp' => Yii::t('app', 'Curp'),
            'rfc' => Yii::t('app', 'Rfc'),
            'nss' => Yii::t('app', 'Nss'),
            'afore' => Yii::t('app', 'Afore'),
            'cartilla_militar' => Yii::t('app', 'Cartilla Militar'),
            'pasaporte' => Yii::t('app', 'Pasaporte'),
            'clase_licencia' => Yii::t('app', 'Clase Licencia'),
            'numero_licencia' => Yii::t('app', 'Numero Licencia'),
            'deporte' => Yii::t('app', 'Deporte'),
            'club' => Yii::t('app', 'Club'),
            'pasatiempo' => Yii::t('app', 'Pasatiempo'),
            'meta' => Yii::t('app', 'Meta'),
            'padre_vivefin' => Yii::t('app', 'Padre Vivefin'),
            'padre_domicilio' => Yii::t('app', 'Padre Domicilio'),
            'padre_ocupacion' => Yii::t('app', 'Padre Ocupacion'),
            'madre_vivefin' => Yii::t('app', 'Madre Vivefin'),
            'madre_domicilio' => Yii::t('app', 'Madre Domicilio'),
            'madre_ocupacion' => Yii::t('app', 'Madre Ocupacion'),
            'pareja_vivefin' => Yii::t('app', 'Pareja Vivefin'),
            'pareja_domicilio' => Yii::t('app', 'Pareja Domicilio'),
            'pareja_ocupacion' => Yii::t('app', 'Pareja Ocupacion'),
            'hijos' => Yii::t('app', 'Hijos'),
            'estudio' => Yii::t('app', 'Estudio'),
            'escuela' => Yii::t('app', 'Escuela'),
            'inicio' => Yii::t('app', 'Inicio'),
            'finalizacion' => Yii::t('app', 'Finalizacion'),
            'titulo' => Yii::t('app', 'Titulo'),
            'idioma' => Yii::t('app', 'Idioma'),
            'funciones_oficina' => Yii::t('app', 'Funciones Oficina'),
            'maquinaria_oficina' => Yii::t('app', 'Maquinaria Oficina'),
            'software' => Yii::t('app', 'Software'),
            'otras_funciones' => Yii::t('app', 'Otras Funciones'),
            'tiempo_trabajo' => Yii::t('app', 'Tiempo Trabajo'),
            'compania' => Yii::t('app', 'Compania'),
            'direccion' => Yii::t('app', 'Direccion'),
            'telefono' => Yii::t('app', 'Telefono'),
            'puesto' => Yii::t('app', 'Puesto'),
            'sueldo_inicial' => Yii::t('app', 'Sueldo Inicial'),
            'sueldo_final' => Yii::t('app', 'Sueldo Final'),
            'motivo_separacion' => Yii::t('app', 'Motivo Separacion'),
            'nombre_jefe' => Yii::t('app', 'Nombre Jefe'),
            'puesto_jefe' => Yii::t('app', 'Puesto Jefe'),
            'solicitud_informe' => Yii::t('app', 'Solicitud Informe'),
            'nombre_ref1' => Yii::t('app', 'Nombre Ref1'),
            'domicilio_ref1' => Yii::t('app', 'Domicilio Ref1'),
            'telefono_ref1' => Yii::t('app', 'Telefono Ref1'),
            'ocupacion_ref1' => Yii::t('app', 'Ocupacion Ref1'),
            'tiempo_ref1' => Yii::t('app', 'Tiempo Ref1'),
            'nombre_ref2' => Yii::t('app', 'Nombre Ref2'),
            'domicilio_ref2' => Yii::t('app', 'Domicilio Ref2'),
            'telefono_ref2' => Yii::t('app', 'Telefono Ref2'),
            'ocupacion_ref2' => Yii::t('app', 'Ocupacion Ref2'),
            'tiempo_ref2' => Yii::t('app', 'Tiempo Ref2'),
            'nombre_ref3' => Yii::t('app', 'Nombre Ref3'),
            'domicilio_ref3' => Yii::t('app', 'Domicilio Ref3'),
            'telefono_ref3' => Yii::t('app', 'Telefono Ref3'),
            'ocupacion_ref3' => Yii::t('app', 'Ocupacion Ref3'),
            'tiempo_ref3' => Yii::t('app', 'Tiempo Ref3'),
            'afianzado' => Yii::t('app', 'Afianzado'),
            'sindicato' => Yii::t('app', 'Sindicato'),
            'seguro_vida' => Yii::t('app', 'Seguro Vida'),
            'viajar' => Yii::t('app', 'Viajar'),
            'cambiar_residencia' => Yii::t('app', 'Cambiar Residencia'),
            'otros_ingresos' => Yii::t('app', 'Otros Ingresos'),
            'importe_ingresos' => Yii::t('app', 'Importe Ingresos'),
            'conyuge_trabaja' => Yii::t('app', 'Conyuge Trabaja'),
            'percepcion' => Yii::t('app', 'Percepcion'),
            'casa_propia' => Yii::t('app', 'Casa Propia'),
            'valor_casa' => Yii::t('app', 'Valor Casa'),
            'paga_renta' => Yii::t('app', 'Paga Renta'),
            'renta' => Yii::t('app', 'Renta'),
            'dependientes' => Yii::t('app', 'Dependientes'),
            'automovil' => Yii::t('app', 'Automovil'),
            'deudas' => Yii::t('app', 'Deudas'),
            'importe_deudas' => Yii::t('app', 'Importe Deudas'),
            'acreedor' => Yii::t('app', 'Acreedor'),
            'abono_mensual' => Yii::t('app', 'Abono Mensual'),
            'gastos_mensuales' => Yii::t('app', 'Gastos Mensuales'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAspirante()
    {
        return $this->hasOne(Aspirante::className(), ['id_usuario' => 'id_aspirante']);
    }
}
