<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $cita app\models\Cita */

$this->title = Yii::t('app', 'Crear Cita');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Citas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cita-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'cita' => $cita,
        'locales' => $locales,
        'va' => $va,
    ]) ?>

</div>
