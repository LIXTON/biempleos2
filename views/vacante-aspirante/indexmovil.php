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

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_aspirante',
            'id_vacante',
            'estado',
            [
               'attribute' => 'view',
                'format' => 'raw',
                'value' => function ($model) {                      
                    return Html::a("<span class='glyphicon glyphicon-eye-open'></span>",["cita/viewmovil","id"=>$model["id"]]);
                },
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
