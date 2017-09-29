<?php
// Este es un ejemplo de como se utiliza FCM para enviar notificaciones a android

// parametros:
/*
	$gcm_keys = array( clave1,clave2,clave3 )
	$title, titulo que tendra el GCM
	$message, mesaje que tendra el GCM
	$
*/
function send_FCM($gcm_keys, $title, $message, $subtitle){
	$api_key = "AQUI VA LA API KEY";

	$registrationIds = $gcm_keys;
	
	// el contenido se encapsula aqui
	$msg = array(
		'message' 	=> $message,
		'title'		=> $title,
		'subtitle'	=> $subtitle,
		'tickerText'	=> '',
		'vibrate'	=> 1,
		'sound'		=> 1,
		'largeIcon'	=> 'large_icon',
		'smallIcon'	=> 'small_icon'
	);
	$fields = array
	(
		'registration_ids' 	=> $registrationIds,
		'data'			=> $msg
	);
	 
	$headers = array
	(
		'Authorization: key=' . API_ACCESS_KEY,
		'Content-Type: application/json'
	);
	 
	$ch = curl_init();
	curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
	curl_setopt( $ch,CURLOPT_POST, true );
	curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
	curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
	curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
	curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
	$result = curl_exec($ch );
	curl_close( $ch );
	return $result;
}