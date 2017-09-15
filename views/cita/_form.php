<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $cita app\models\Cita */
/* @var $locales[] app\models\Local */
/* @var $va[] app\models\VacanteAspirante */
/* @var $form yii\widgets\ActiveForm */

$locales = ArrayHelper::map($locales, 'id', function ($locales, $defaultValue) {
    return $locales->calle . ' ' . $locales->numero . ' ' . $locales->colonia . ' C.P. ' . $locales->codigo_postal . ' ' . $locales->ciudad . ', ' . $locales->estado . ', ' . $locales->pais;
});
$va = ArrayHelper::map($va, 'id', function ($va, $defaultValue) {
    return $va->idAspirate->solicitud->nombre;
});
?>

<div class="cita-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($va, 'id')->checkBoxList($va) ?>

    <?= $form->field($cita, 'id_local')->dropdownList($locales, ['prompt' => Yii::t('app', 'Selecciona un local')])->label('Local') ?>

    <?= $form->field($cita, 'direccion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($cita, 'fecha')->textInput() ?>

    <?= $form->field($cita, 'mensaje')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($cita->isNewRecord ? Yii::t('app', 'Crear') : Yii::t('app', 'Actualizar'), ['class' => $cita->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
