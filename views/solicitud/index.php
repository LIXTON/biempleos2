<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Solicituds');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="solicitud-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Solicitud'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_aspirante',
            'foto:ntext',
            'nombre:ntext',
            'fecha_nacimiento',
            'sexo',
            // 'nacionalidad:ntext',
            // 'estatura',
            // 'peso',
            // 'estado_civil',
            // 'calle:ntext',
            // 'numero:ntext',
            // 'colonia:ntext',
            // 'codigo_postal:ntext',
            // 'curp:ntext',
            // 'rfc:ntext',
            // 'nss:ntext',
            // 'afore:ntext',
            // 'cartilla_militar:ntext',
            // 'pasaporte:ntext',
            // 'licencia',
            // 'clase_licencia',
            // 'numero_licencia:ntext',
            // 'deportista',
            // 'deporte:ntext',
            // 'club',
            // 'pasatiempo:ntext',
            // 'meta:ntext',
            // 'estudio',
            // 'escuela:ntext',
            // 'inicio',
            // 'finalizacion',
            // 'titulo',
            // 'idioma:ntext',
            // 'porcentaje',
            // 'funciones_oficina:ntext',
            // 'maquinaria_oficina:ntext',
            // 'software:ntext',
            // 'otras_funciones:ntext',
            // 'trabajo_anterior',
            // 'tiempo_trabajo',
            // 'compania:ntext',
            // 'direccion:ntext',
            // 'telefono:ntext',
            // 'puesto:ntext',
            // 'sueldo_inicial',
            // 'sueldo_final',
            // 'motivo_separacion:ntext',
            // 'nombre_jefe:ntext',
            // 'puesto_jefe:ntext',
            // 'nombre_ref1:ntext',
            // 'domicilio_ref1:ntext',
            // 'telefono_ref1:ntext',
            // 'ocupacion_ref1:ntext',
            // 'tiempo_ref1',
            // 'nombre_ref2:ntext',
            // 'domicilio_ref2:ntext',
            // 'telefono_ref2:ntext',
            // 'ocupacion_ref2:ntext',
            // 'tiempo_ref2',
            // 'nombre_ref3:ntext',
            // 'domicilio_ref3:ntext',
            // 'telefono_ref3:ntext',
            // 'ocupacion_ref3:ntext',
            // 'tiempo_ref3',
            // 'parientes',
            // 'afianzado',
            // 'sindicato',
            // 'seguro_vida',
            // 'viajar',
            // 'cambiar_residencia',
            // 'otros_ingresos',
            // 'importe_ingresos',
            // 'conyuge_trabaja',
            // 'percepcion',
            // 'casa_propia',
            // 'valor_casa',
            // 'paga_renta',
            // 'renta',
            // 'dependientes',
            // 'automovil',
            // 'deudas',
            // 'importe_deudas',
            // 'acreedor:ntext',
            // 'abono_mensual',
            // 'gastos_mensuales',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
