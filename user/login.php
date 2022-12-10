<?php
include '../header.php';
try {
	$con = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

	if (!$con) {
		echo '{"codigo":400,"mensaje":"Error intentando conectar","respuesta":""}';
	} else {
		$register_user = $_GET['user'];
		$register_pass = $_GET['pass'];
		$register_mail = $_GET['mail'];
		$register_coid = $_GET['connect_id'];

		$sql = "INSERT INTO `gcg_users` (`id`, `user`, `pass`, `mail`, `connect_id`) 
						VALUES (NULL, '".$register_user."', '".$register_pass."', '".$register_mail."', '".$register_coid."');"
	
		if($con->query($sql)===TRUE){
			echo '{"codigo":200,"mensaje":"Ejecución con éxito","respuesta":""}';
		} else {
			echo '{"codigo":1,"mensaje":"Error al crear usuario","respuesta":""}';			
		}

	}	
} catch (Exception $e){
	echo '{"codigo":1,"mensaje":"No se pudo registrar el usuario","respuesta":""}';
}

include '../footer.php';