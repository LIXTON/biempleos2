<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\VacanteAspirante */

$this->title = Yii::t('app', 'Create Vacante Aspirante');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Vacante Aspirantes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vacante-aspirante-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
