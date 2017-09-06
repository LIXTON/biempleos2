<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Cita */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Cita',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Citas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id, 'id_empresa' => $model->id_empresa]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="cita-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
