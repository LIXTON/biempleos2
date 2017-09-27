<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Vacantes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vacante-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Crear Vacante'), ['create'], ['class' => 'btn btn-success']); ?>
    </p>
    <?php Pjax::begin(); ?>    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'id_empresa',
            'id_local',
            'puesto',
            'sueldo',
            // 'ofrece:ntext',
            // 'requisito:ntext',
            'horario',
            'fecha_publicacion',
            // 'fecha_finalizacion',
            'no_cita',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {lista}',
                'buttons' => [
                    'lista' => function ($url, $model, $key) {
                        return Html::a('<span class=\'glyphicon glyphicon-th-list\'></span>', ['vacante-aspirante/index', 'id_vacante' => $model->id]);
                    }
                ],
                'urlCreator' => function ($action, $model, $key, $index, $this) {
                    return $action . "?id=" .  $model->id . "&id_empresa=" .  $model->id_empresa . "&id_local=" .  $model->id_local;
                }
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
