<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Vacante Aspirantes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vacante-aspirante-index">

    <h1><?= Html::encode($this->title) ?></h1>

<?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'aspirante',
            'fecha',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    /*'lista' => function ($url, $model, $key) {
                        return Html::a('<span class=\'glyphicon glyphicon-th-list\'></span>', ['vacante-aspirante/index', 'id_vacante' => $model->id]);
                    }*/
                ],
                'urlCreator' => function ($action, $model, $key, $index, $this) {
                    return $action . "?id=" . $model['id'];
                }
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
