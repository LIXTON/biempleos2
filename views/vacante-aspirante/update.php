<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\VacanteAspirante */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Vacante Aspirante',
]) . $model->id_usuario;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Vacante Aspirantes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_usuario, 'url' => ['view', 'id_usuario' => $model->id_usuario, 'id_vacante' => $model->id_vacante]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="vacante-aspirante-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
