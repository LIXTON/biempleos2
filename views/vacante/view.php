<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Vacante */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Vacantes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vacante-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        switch(Yii::$app->user->identity->rol) {
            case "empresa":
                echo Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id, 'id_empresa' => $model->id_empresa, 'id_local' => $model->id_local], ['class' => 'btn btn-primary']);
            
                echo Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id, 'id_empresa' => $model->id_empresa, 'id_local' => $model->id_local], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
                ]);
                break;
            case "aspirante":
                //  Opciones de aspirante
                echo Html::a(Yii::t('app', 'Aplicar a vacante'), 
                             ['vacante-aspirante/create'],
                             [
                                 'class' => 'btn btn-success',
                                 'data' => [
                                     'params' => ['id' => $model->id],
                                     'method' => 'post',
                                 ],
                             ]);
                break;
        }
        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_empresa',
            'id_local',
            'puesto',
            'sueldo',
            'ofrece:ntext',
            'requisito:ntext',
            'horario',
            'fecha_publicacion',
            'fecha_finalizacion',
            'no_cita',
        ],
    ]) ?>

</div>
