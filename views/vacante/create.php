<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Vacante */

$this->title = Yii::t('app', 'Crear Vacante');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Vacantes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vacante-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'vacante' => $vacante,
        'local' => $local,
        'ep' => $ep,
    ]) ?>

</div>
