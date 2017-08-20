<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Solicitud */

$this->title = Yii::t('app', 'Create Solicitud');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Solicituds'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="solicitud-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
