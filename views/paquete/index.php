<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Paquetes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paquete-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        if (Yii::$app->user->identify->rol == 'admin') {
            echo Html::a(Yii::t('app', 'Create Paquete'), ['create'], ['class' => 'btn btn-success']);
        }
        ?>
    </p>
    
    <div class="row">
    <?php foreach($paquetes as $p): ?>
    <?php
    if (empty($p->descripcion))
        continue;
    ?>
        <div class="col-sm-2">
            <div class="panel panel-default">
                <div class="panel-heading"><?= $p->nombre ?></div>
                <div class="panel-body">
                    <p><?= $p->descripcion ?></p>
                    <p>Numero de vacantes: <?= $p->no_vacante ?></p>
                    <p>Numero de citas: <?= $p->no_cita ?><br>
                        <sub><?= $p->no_cita / $p->no_vacante ?> citas por vacante</sub>
                    </p>
                    <p>Duracion: <?= $p->duracion ?></p>
                    <p><?= $p->oferta->descuento ?> de descuento en pago por uso</p>
                    <h3><?= $p->precio ?></h3>
                    <?= Html::a('Seleccionar', ['empresa-paquete/contratar', 'paquete' => $p->id], ['class' => 'btn btn-default']) ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
    <h2>Pago por uso</h2>
    <div class="col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading">Vacante</div>
            <div class="panel-body">
                <?php foreach($paquetes as $p): ?>
                <?php if ($p->nombre == "[PUV]"): ?>
                <div class="col-sm-4">
                    <p><?= $p->no_vacante . $p->no_vacante == 1 ? " vacante adicional":"vacantes adicionales" ?></p>
                    <p>Numero de citas: <?= $p->no_cita ?>
                        <?php if ($p->no_vacante > 1): ?>
                        <br><sub><?= $p->no_cita / $p->no_vacante ?> citas por vacante</sub>
                        <?php endif; ?>
                    </p>
                    <p>Duración <?= $p->duracion ?></p>
                    <h3><?= $p->precio ?></h3>
                </div>
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading">Cita</div>
            <div class="panel-body">
                <?php foreach($paquetes as $p): ?>
                <?php if ($p->nombre == "[PUC]"): ?>
                <div class="col-sm-4">
                    <p>Citas adicionales a una vacante: <?= $p->no_cita ?></p>
                    <h3><?= $p->precio ?></h3>
                </div>
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php /*Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nombre',
            'descripcion:ntext',
            'no_vacante',
            'no_cita',
            // 'duracion',
            // 'precio',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); */?>
</div>
