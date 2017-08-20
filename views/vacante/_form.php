<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Vacante */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vacante-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_usuario')->textInput() ?>

    <?= $form->field($model, 'id_local')->textInput() ?>

    <?= $form->field($model, 'puesto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sueldo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ofrece')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'requisito')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'horario')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fecha_publicacion')->textInput() ?>

    <?= $form->field($model, 'fecha_finalizacion')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
