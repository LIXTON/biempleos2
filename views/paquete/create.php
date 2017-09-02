<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Paquete */

$this->title = Yii::t('app', 'Create Paquete');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Paquetes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paquete-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
