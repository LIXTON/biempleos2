<?php
use yii\helpers\Html;
// Todo el documento fue creado desde cero
// Aquí se muestra todas las opciones
?>

<h1>Panel de usuario</h1>

<p>Opciones disponibles: <?php echo Yii::$app->user->id; ?></p>

<?= Html::a('Editar Curriculum', ['solicitud/update']) ?> <br><br>

<?= Html::a('Ver notificaciones', ['vacante-aspirante/index']) ?> <br><br>

<?= Html::a('ver vacantes', ['vacante/index']) ?> <br><br>
