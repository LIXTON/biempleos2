<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Cita */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Citas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cita-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id, 'id_empresa' => $model->id_empresa], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id, 'id_empresa' => $model->id_empresa], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'aspirante',
            'respuesta',
            [
                'class' => 'yii\grid\DataColumn',
                'header' => 'Lugar',
                'value' => function ($data) {
                    return empty($data->local) ? $data->direccion : $data->local;
                },
            ],
            'fecha',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
