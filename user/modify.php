<?php
include '../header.php';
try {
	$con = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

	if (!$con) {
		echo '{"codigo":400,"mensaje":"Error intentando conectar","respuesta":""}';
	} else {

		if(isset($_GET['id']) && isset($_GET['avatar']) && isset($_GET['description'])) {

			$modify_id = $_GET['id'];
			$modify_avatar = $_GET['avatar'];
			$modify_description = $_GET['description'];

			$sql = "UPDATE `gcg_users`
					SET
					avatar = '".$modify_avatar."',
					description = '".$modify_description."',
					VALUES id = '".$modify_id."';"
		
			if($con->query($sql)===TRUE){
				echo '{"codigo":0,"mensaje":"Ejecución con éxito","respuesta":null}';
			} else {
				echo '{"codigo":1,"mensaje":"Error al modificar usuario","respuesta":null}';
			}

		} else  {
			echo '{"codigo":-1,"mensaje":"Datos incompletos","respuesta":null}';
		}
	}	
} catch (Exception $e){
	echo '{"codigo":1,"mensaje":"No se pudo registrar el usuario","respuesta":null}';
}
include '../footer.php';