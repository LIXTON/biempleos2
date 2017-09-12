<?php
use yii\helpers\Html;
// Todo el documento fue creado desde cero
// Aquí se muestra todas las opciones
	// verifica la existencia de la solicitud //
	if($data["nombre"] == "no set"){
		// si no tiene solicitud da mensaje de bienvenida y pide que la rellenen //
		echo "<h1>Bienvenido a Biempleos</h1>";
		echo "<p>Hola, antes de poder utilizar nuestros servicios es necesario que llenes tu solicitud de empleo. Por medio de la solicitud de empleo los empleadores podrán ver tus cualidades para contratarte. Es necesario que llenes la solicitud correctamente para que tengas más posibilidades de ser contratado.</p>";
		echo Html::a('<h2>Llena tu solicitud aquí</h2>', ['solicitud/create']);
	}
	else{
		// si existe solicitud muestra las opciones disponibles //
		echo "<h1>Panel de usuario</h1>";
		echo "<p>Hola, " . $data["nombre"] . " tus opciones disponibles son: </p>";
		echo Html::a('<h2>Editar Solicitud</h2>', ['solicitud/update']) . "<br>";
		echo Html::a('<h2>Ver notificaciones</h2>', ['vacante-aspirante/index']) . "<br>";
		echo Html::a('<h2>¿Buscas empleo?</h2>', ['vacante/indexmovil']) . "<br>";
	}
?>