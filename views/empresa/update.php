<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Empresa */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Empresa',
]) . $empresa->id_usuario;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Empresas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $empresa->id_usuario, 'url' => ['view', 'id' => $empresa->id_usuario]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="empresa-update">

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
