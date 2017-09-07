<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Empresa */

$this->title = 'Cambiar contraseña';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chgpassword-form">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($chgPassword, 'contrasena', ['enableAjaxValidation' => true])->passwordInput() ?>

    <?= $form->field($chgPassword, 'new_contrasena')->passwordInput() ?>

    <?= $form->field($chgPassword, 'recontrasena')->passwordInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Actualizar'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
