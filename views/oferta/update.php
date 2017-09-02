<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Oferta */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Oferta',
]) . $model->id_paquete;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ofertas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_paquete, 'url' => ['view', 'id' => $model->id_paquete]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="oferta-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
