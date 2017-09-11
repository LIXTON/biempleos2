<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Empresa */

$this->title = $empresa->nombre;
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Empresas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="empresa-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Ver vacantes'), ['//vacante/index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Ver locales'), ['//local/index'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Ver citas'), ['//cita/index'], ['class' => 'btn btn-info']) ?>
        <?php /*Html::a(Yii::t('app', 'Update'), ['update'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete'], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ])*/ ?>
    </p>
    
    <?= GridView::widget([
        'dataProvider' => $ep,
    ]) ?>

</div>
