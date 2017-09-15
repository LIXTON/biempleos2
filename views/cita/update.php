<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $cita app\models\Cita */

$this->title = Yii::t('app', 'Editar {modelClass}: ', [
    'modelClass' => 'Cita',
]) . $cita->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Citas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $cita->id, 'url' => ['view', 'id' => $cita->id, 'id_empresa' => $cita->id_empresa]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="cita-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'cita' => $cita,
        'locales' => $locales,
        'va' => $va,
    ]) ?>

</div>
