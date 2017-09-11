<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $vacante app\models\Vacante */

$this->title = Yii::t('app', 'Editar {modelClass}: ', [
    'modelClass' => 'Vacante',
]) . $vacante->puesto;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Vacantes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $vacante->puesto, 'url' => ['view', 'id' => $vacante->id, 'id_empresa' => $vacante->id_empresa, 'id_local' => $vacante->id_local]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Editar');
?>
<div class="vacante-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'vacante' => $vacante,
        'local' => $local,
        'ep' => $ep,
    ]) ?>

</div>
