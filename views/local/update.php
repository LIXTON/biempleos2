<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Local */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Local',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Locals'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id, 'id_empresa' => $model->id_empresa]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="local-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
