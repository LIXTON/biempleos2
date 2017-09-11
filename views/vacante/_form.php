<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $vacante app\models\Vacante */
/* @var $form yii\widgets\ActiveForm */
$locales = ArrayHelper::map($local, 'id', function ($local, $defaultValue) {
    return $local->calle . ' ' . $local->numero . ' ' . $local->colonia . ' C.P. ' . $local->codigo_postal . ' ' . $local->ciudad . ', ' . $local->estado . ', ' . $local->pais;
});
?>

<div class="vacante-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    if($vacante->isNewRecord) {
        $eps = ArrayHelper::map($ep, 'id', function ($eps, $defaultValue) {
            return $eps->idPaquete->nombre;
        });
        echo $form->field($ep[0], 'id')->dropdownList($eps, ['prompt' => Yii::t('app', 'Escoge el paquete a usar')])->label('Paquete');
    }
    ?>

    <?= $form->field($vacante, 'id_local')->dropdownList($locales, ['prompt' => Yii::t('app', 'Selecciona un local')])->label('Local') ?>

    <?= $form->field($vacante, 'puesto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($vacante, 'sueldo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($vacante, 'ofrece')->textarea(['rows' => 6]) ?>

    <?= $form->field($vacante, 'requisito')->textarea(['rows' => 6]) ?>

    <?= $form->field($vacante, 'horario')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($vacante->isNewRecord ? Yii::t('app', 'Crear') : Yii::t('app', 'Actualizar'), ['class' => $vacante->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'name' => 'principal', 'value' => '1']) ?>
        <?= Html::submitButton(Yii::t('app', 'Publicar'), ['class' => 'btn btn-primary', 'name' => 'publicar', 'value' => 2]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
