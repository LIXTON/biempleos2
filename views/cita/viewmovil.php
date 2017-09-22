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

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_empresa',
            'id_local',
            'direccion',
            'fecha',
            'mensaje:ntext',
        ],
    ]) ?>
    <div class="row">
        <?php
            if($model["respuesta"]==""){
                echo Html::a("Aceptar",
                    ["cita/updateestado","id"=>$model['id'], "respuesta"=>"si asistire"],
                    ["class"=>"col-xs-4 btn btn-success"]
                );
                echo Html::a("Cancelar",
                    ["cita/updatestado","id"=>$model['id'], "respuesta"=>"no ire"],
                    ["class"=>"col-xs-4 btn btn-danger"]
                );
                echo Html::a("Posponer",
                    ["cita/updatestado","id"=>$model['id'], "respuesta"=>"posponla"],
                    ["class"=>"col-xs-4 btn btn-warning"]
                );
            }
        ?>
    </div>

</div>
