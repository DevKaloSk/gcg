<?php
include '../header.php';
try {
	$con = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

	if (!$con) {
		echo '{"code":404,"message":"Error intentando conectar","data":null}';
	} else {

		if(isset($_POST['user']) && isset($_POST['pass']) && isset($_POST['mail']) && isset($_POST['connect_id'])) {

			$register_user = $_POST['user'];
			$register_pass = $_POST['pass'];
			$register_mail = $_POST['mail'];
			$register_coid = $_POST['connect_id'];

			$sql = "INSERT INTO `gcg_users` (`id`, `user`, `pass`, `mail`, `connect_id`) 
					VALUES (NULL, '".$register_user."', '".$register_pass."', '".$register_mail."', '".$register_coid."');";
		
			if($con->query($sql)===TRUE){
				echo '{"code":0,"message":"Ejecución con éxito","data":null}';
			} else {
				echo '{"code":1,"message":"Error al crear usuario","data":null}';
			}

		} else  {
			echo '{"code":-1,"message":"Datos incompletos","data":null}';
		}
	}
} catch (Exception $e){
	echo '{"code":1,"message":"No se pudo registrar el usuario","data":null}';
}
include '../footer.php';