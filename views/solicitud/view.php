<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Solicitud */

$this->title = $model->id_aspirante;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Solicituds'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="solicitud-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id_aspirante], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id_aspirante], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_aspirante',
            'foto:ntext',
            'nombre:ntext',
            'fecha_nacimiento',
            'sexo',
            'nacionalidad:ntext',
            'estatura',
            'peso',
            'estado_civil',
            'calle:ntext',
            'numero:ntext',
            'colonia:ntext',
            'codigo_postal:ntext',
            'lugar_residencia',
            'lugar_nacimiento',
            'vive_con',
            'curp:ntext',
            'rfc:ntext',
            'nss:ntext',
            'afore:ntext',
            'cartilla_militar:ntext',
            'pasaporte:ntext',
            'clase_licencia',
            'numero_licencia:ntext',
            'deporte:ntext',
            'club',
            'pasatiempo:ntext',
            'meta:ntext',
            'padre_vivefin',
            'padre_domicilio',
            'padre_ocupacion',
            'madre_vivefin',
            'madre_domicilio',
            'madre_ocupacion',
            'pareja_vivefin',
            'pareja_domicilio',
            'pareja_ocupacion',
            'hijos',
            'estudio',
            'escuela:ntext',
            'inicio',
            'finalizacion',
            'titulo',
            'idioma:ntext',
            'funciones_oficina:ntext',
            'maquinaria_oficina:ntext',
            'software:ntext',
            'otras_funciones:ntext',
            'tiempo_trabajo',
            'compania:ntext',
            'direccion:ntext',
            'telefono:ntext',
            'puesto:ntext',
            'sueldo_inicial',
            'sueldo_final',
            'motivo_separacion:ntext',
            'nombre_jefe:ntext',
            'puesto_jefe:ntext',
            'solicitud_informe',
            'nombre_ref1:ntext',
            'domicilio_ref1:ntext',
            'telefono_ref1:ntext',
            'ocupacion_ref1:ntext',
            'tiempo_ref1',
            'nombre_ref2:ntext',
            'domicilio_ref2:ntext',
            'telefono_ref2:ntext',
            'ocupacion_ref2:ntext',
            'tiempo_ref2',
            'nombre_ref3:ntext',
            'domicilio_ref3:ntext',
            'telefono_ref3:ntext',
            'ocupacion_ref3:ntext',
            'tiempo_ref3',
            'afianzado',
            'sindicato',
            'seguro_vida',
            'viajar',
            'cambiar_residencia',
            'otros_ingresos',
            'importe_ingresos',
            'conyuge_trabaja',
            'percepcion',
            'casa_propia',
            'valor_casa',
            'paga_renta',
            'renta',
            'dependientes',
            'automovil',
            'deudas',
            'importe_deudas',
            'acreedor:ntext',
            'abono_mensual',
            'gastos_mensuales',
        ],
    ]) ?>

</div>
