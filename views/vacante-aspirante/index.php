<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Vacante Aspirantes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vacante-aspirante-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        $form = ActiveForm::begin([
            'id' => 'form-grpCitar',
            'action' => ['cita/create', 'vacante' => $id_vacante],
            'method' => 'get',
        ]);
        echo Html::submitButton('Citar Seleccionados', ['class' => 'btn btn-success']);
        ActiveForm::end();
        ?>
    </p>
<?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'aspirante',
            'fecha',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view-aspirante}',
                'buttons' => [
                    'view-aspirante' => function ($url, $model, $key) {
                        return Html::a('<span class=\'glyphicon glyphicon-eye-open\'></span>', $url);
                    }
                ],
                'urlCreator' => function ($action, $model, $key, $index, $this) {
                    return $action . "?id=" . $model['id'];
                }
            ],
            [
                'class' => 'yii\grid\CheckboxColumn',
                'checkboxOptions' => function ($model, $key, $index, $column) {
                    return [
                        'form' => 'form-grpCitar',
                        'value' => $model['id_aspirante']
                    ];
                },
                'name' => 'aspirante'
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
