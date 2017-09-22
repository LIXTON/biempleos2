<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Solicitud */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="solicitud-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php 
        // campo no necesario
        // $form->field($model, 'id_aspirante')->textInput() 
    ?>
    <div class="row">
        <div class="col-md-6">
        <h2>Datos personales:</h2>
            <?= $form->field($model, 'nombre')->textInput() ?>
            <?= $form->field($model, 'fecha_nacimiento')->textInput() ?>

            <?= $form->field($model, 'sexo')->dropDownList(["1"=>"hombre","2"=>"mujer"]) ?>
            <?= $form->field($model, 'nacionalidad')->dropDownList(["1"=>"MX","2"=>"US"]) ?>

            <?= $form->field($model, 'estatura')->textInput() ?>
            <?= $form->field($model, 'peso')->textInput() ?>
            <?= $form->field($model, 'estado_civil')->dropDownList([
                                                        "1"=>"Soltero/a",
                                                        "2"=>"Comprometido/a",
                                                        "3"=>"Casado/a",
                                                        "4"=>"Divorciado/a",
                                                        "5"=>"Viudo/a"
                                                    ]) ?>
        </div>
        <div class="col-md-6">
            <h2>Documentación:</h2>
            <?= $form->field($model, 'curp')->textInput() ?>
            <?= $form->field($model, 'rfc')->textInput() ?>
            <?= $form->field($model, 'nss')->textInput() ?>
            <?= $form->field($model, 'afore')->textInput() ?>
            <?= $form->field($model, 'cartilla_militar')->textInput() ?>
            <?= $form->field($model, 'pasaporte')->textInput() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h2>Dirección:</h2>
            <?= $form->field($model, 'calle')->textInput() ?>
            <?= $form->field($model, 'numero')->textInput() ?>
            <?= $form->field($model, 'colonia')->textInput() ?>
            <?= $form->field($model, 'codigo_postal')->textInput() ?>
            <?= $form->field($model, 'licencia')->textInput() ?>
            <?= $form->field($model, 'clase_licencia')->textInput() ?>
            <?= $form->field($model, 'numero_licencia')->textInput() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <h2>Habitos personales:</h2>
            <?= $form->field($model, 'deportista')->dropDownList(["1"=>"Simon", "2"=>"ni maiz"]) ?>
            <?= $form->field($model, 'deporte')->textInput() ?>
            <?= $form->field($model, 'club')->dropDownList(["1"=>"Simon", "2"=>"ni maiz"]) ?>
            <?= $form->field($model, 'pasatiempo')->textInput() ?>
            <?= $form->field($model, 'meta')->textInput() ?>
        </div>
        <div class="col-md-6">
            <h2>Datos Escolares:</h2>
            <?= $form->field($model, 'estudio')->dropDownList(["1"=>"Simon", "2"=>"ni maiz"]) ?>
            <?= $form->field($model, 'escuela')->textInput() ?>
            <?= $form->field($model, 'inicio')->textInput() ?>
            <?= $form->field($model, 'finalizacion')->textInput() ?>
            <?= $form->field($model, 'titulo')->textInput() ?>    
        </div>
    </div>

    <div class="row">
        <h2>Referencias:</h2>
        <div class="col-md-4">
            <h3>Referencia #1</h3>
            <?= $form->field($model, 'nombre_ref1')->textInput() ?>
            <?= $form->field($model, 'domicilio_ref1')->textInput() ?>
            <?= $form->field($model, 'telefono_ref1')->textInput() ?>
            <?= $form->field($model, 'ocupacion_ref1')->textInput() ?>
            <?= $form->field($model, 'tiempo_ref1')->textInput() ?>
        </div>

        <div class="col-md-4">
            <h3>Referencia #1</h3>
            <?= $form->field($model, 'nombre_ref2')->textInput() ?>
            <?= $form->field($model, 'domicilio_ref2')->textInput() ?>
            <?= $form->field($model, 'telefono_ref2')->textInput() ?>
            <?= $form->field($model, 'ocupacion_ref2')->textInput() ?>
            <?= $form->field($model, 'tiempo_ref2')->textInput() ?>
        </div>

        <div class="col-md-4">
            <h3>Referencia #1</h3>
            <?= $form->field($model, 'nombre_ref3')->textInput() ?>
            <?= $form->field($model, 'domicilio_ref3')->textInput() ?>
            <?= $form->field($model, 'telefono_ref3')->textInput() ?>
            <?= $form->field($model, 'ocupacion_ref3')->textInput() ?>
            <?= $form->field($model, 'tiempo_ref3')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <h2>Datos económicos:</h2>
            <?= $form->field($model, 'afianzado')->dropDownList(["1"=>"Simon", "2"=>"ni maiz"]) ?>
            <?= $form->field($model, 'sindicato')->dropDownList(["1"=>"Simon", "2"=>"ni maiz"]) ?>
            <?= $form->field($model, 'seguro_vida')->dropDownList(["1"=>"Simon", "2"=>"ni maiz"]) ?>
            <?= $form->field($model, 'viajar')->dropDownList(["1"=>"Simon", "2"=>"ni maiz"]) ?>
            <?= $form->field($model, 'cambiar_residencia')->dropDownList(["1"=>"Simon", "2"=>"ni maiz"]) ?>
            <?= $form->field($model, 'otros_ingresos')->dropDownList(["1"=>"Simon", "2"=>"ni maiz"]) ?>
            <?= $form->field($model, 'importe_ingresos')->textInput() ?>
            <?= $form->field($model, 'conyuge_trabaja')->dropDownList(["1"=>"Simon", "2"=>"ni maiz"]) ?>
            <?= $form->field($model, 'percepcion')->textInput() ?>
            <?= $form->field($model, 'casa_propia')->dropDownList(["1"=>"Simon", "2"=>"ni maiz"]) ?>
            <?= $form->field($model, 'valor_casa')->textInput() ?>
            <?= $form->field($model, 'paga_renta')->dropDownList(["1"=>"Simon", "2"=>"ni maiz"]) ?>
            <?= $form->field($model, 'renta')->textInput() ?>
            <?= $form->field($model, 'dependientes')->dropDownList(["1"=>"Simon", "2"=>"ni maiz"]) ?>
            <?= $form->field($model, 'automovil')->dropDownList(["1"=>"Simon", "2"=>"ni maiz"]) ?>
            <?= $form->field($model, 'deudas')->dropDownList(["1"=>"Simon", "2"=>"ni maiz"]) ?>
            <?= $form->field($model, 'importe_deudas')->textInput() ?>
            <?= $form->field($model, 'acreedor')->dropDownList(["1"=>"Simon", "2"=>"ni maiz"]) ?>
            <?= $form->field($model, 'abono_mensual')->textInput() ?>
            <?= $form->field($model, 'gastos_mensuales')->textInput() ?>
        </div>

        <div class="col-md-6">
            <h2>Conocimientos generales:</h2>
            <?= $form->field($model, 'idioma')->textInput() ?>
            <?= $form->field($model, 'porcentaje')->textInput() ?>
            <?= $form->field($model, 'funciones_oficina')->textInput() ?>
            <?= $form->field($model, 'maquinaria_oficina')->textInput() ?>
            <?= $form->field($model, 'software')->textInput() ?>
            <?= $form->field($model, 'otras_funciones')->textInput() ?>
        </div>

        <div class="col-md-6">
            <h2>Experiencia anterior:</h2>
            <?= $form->field($model, 'trabajo_anterior')->textInput() ?>
            <?= $form->field($model, 'tiempo_trabajo')->textInput() ?>
            <?= $form->field($model, 'compania')->textInput() ?>
            <?= $form->field($model, 'direccion')->textInput() ?>
            <?= $form->field($model, 'telefono')->textInput() ?>
            <?= $form->field($model, 'puesto')->textInput() ?>
            <?= $form->field($model, 'sueldo_inicial')->textInput() ?>
            <?= $form->field($model, 'sueldo_final')->textInput() ?>
            <?= $form->field($model, 'motivo_separacion')->textInput() ?>
            <?= $form->field($model, 'nombre_jefe')->textInput() ?>
            <?= $form->field($model, 'puesto_jefe')->textInput() ?>
        </div>

    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
