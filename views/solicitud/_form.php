<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Solicitud */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="solicitud-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_aspirante')->textInput() ?>

    <?= $form->field($model, 'foto')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'nombre')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'fecha_nacimiento')->textInput() ?>

    <?= $form->field($model, 'sexo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nacionalidad')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'estatura')->textInput() ?>

    <?= $form->field($model, 'peso')->textInput() ?>

    <?= $form->field($model, 'estado_civil')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'calle')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'numero')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'colonia')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'codigo_postal')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'lugar_residencia')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lugar_nacimiento')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vive_con')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'curp')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'rfc')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'nss')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'afore')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'cartilla_militar')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'pasaporte')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'clase_licencia')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'numero_licencia')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'deporte')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'club')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pasatiempo')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'meta')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'padre_vivefin')->textInput() ?>

    <?= $form->field($model, 'padre_domicilio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'padre_ocupacion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'madre_vivefin')->textInput() ?>

    <?= $form->field($model, 'madre_domicilio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'madre_ocupacion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pareja_vivefin')->textInput() ?>

    <?= $form->field($model, 'pareja_domicilio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pareja_ocupacion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'hijos')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'estudio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'escuela')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'inicio')->textInput() ?>

    <?= $form->field($model, 'finalizacion')->textInput() ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'idioma')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'funciones_oficina')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'maquinaria_oficina')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'software')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'otras_funciones')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'tiempo_trabajo')->textInput() ?>

    <?= $form->field($model, 'compania')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'direccion')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'telefono')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'puesto')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sueldo_inicial')->textInput() ?>

    <?= $form->field($model, 'sueldo_final')->textInput() ?>

    <?= $form->field($model, 'motivo_separacion')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'nombre_jefe')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'puesto_jefe')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'solicitud_informe')->textInput() ?>

    <?= $form->field($model, 'nombre_ref1')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'domicilio_ref1')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'telefono_ref1')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'ocupacion_ref1')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'tiempo_ref1')->textInput() ?>

    <?= $form->field($model, 'nombre_ref2')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'domicilio_ref2')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'telefono_ref2')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'ocupacion_ref2')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'tiempo_ref2')->textInput() ?>

    <?= $form->field($model, 'nombre_ref3')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'domicilio_ref3')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'telefono_ref3')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'ocupacion_ref3')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'tiempo_ref3')->textInput() ?>

    <?= $form->field($model, 'afianzado')->textInput() ?>

    <?= $form->field($model, 'sindicato')->textInput() ?>

    <?= $form->field($model, 'seguro_vida')->textInput() ?>

    <?= $form->field($model, 'viajar')->textInput() ?>

    <?= $form->field($model, 'cambiar_residencia')->textInput() ?>

    <?= $form->field($model, 'otros_ingresos')->textInput() ?>

    <?= $form->field($model, 'importe_ingresos')->textInput() ?>

    <?= $form->field($model, 'conyuge_trabaja')->textInput() ?>

    <?= $form->field($model, 'percepcion')->textInput() ?>

    <?= $form->field($model, 'casa_propia')->textInput() ?>

    <?= $form->field($model, 'valor_casa')->textInput() ?>

    <?= $form->field($model, 'paga_renta')->textInput() ?>

    <?= $form->field($model, 'renta')->textInput() ?>

    <?= $form->field($model, 'dependientes')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'automovil')->textInput() ?>

    <?= $form->field($model, 'deudas')->textInput() ?>

    <?= $form->field($model, 'importe_deudas')->textInput() ?>

    <?= $form->field($model, 'acreedor')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'abono_mensual')->textInput() ?>

    <?= $form->field($model, 'gastos_mensuales')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
