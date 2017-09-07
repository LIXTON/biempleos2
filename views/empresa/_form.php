<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Empresa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="empresa-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php $form->field($empresa, 'id_usuario')->textInput() ?>

    <?= $form->field($empresa, 'nombre')->textInput(['maxlength' => true]) ?>
    
    <div class="form-group">
        <?= Html::submitButton($empresa->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $empresa->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
