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
        <?php
        switch(Yii::$app->user->identity->rol) {
            case "empresa":
                echo Html::a(Yii::t('app', 'Crear Vacante'), ['create'], ['class' => 'btn btn-success']);
                break;
            case "aspirante":
                //  Opciones aspirante
                break;
        }
        ?>
    </p>

    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'id_empresa',
            'id_local',
            'puesto',
            'sueldo',
            'horario',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{aplicar} {view}',
                'buttons' => [
                    'aplicar' => function ($url, $model, $key) {
                        return Html::a(
                            '<span class=\'glyphicon glyphicon-plus\'></span>', 
                            ['vacante-aspirante/create'], 
                            [
                                'data' => [
                                    'method' => 'post',
                                    'params' => ['id' => $model->id]
                                ]
                            ]
                        );
                    }
                ],
                'urlCreator' => function ($action, $model, $key, $index, $this) {
                    return $action . "?id=" .  $model['id'] . "&id_empresa=" .  $model['id_empresa'] . "&id_local=" .  $model['id_local'];
                }
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
