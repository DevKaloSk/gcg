<?php
include '../header.php';
try {
	$con = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

	if (!$con) {
		echo '{"codigo":400,"mensaje":"Error intentando conectar","respuesta":""}';
	} else {

		if(isset($_GET['user']) && isset($_GET['pass'])) {

			$login_user = $_GET['user'];
			$login_pass = $_GET['pass'];

			$sql = "SELECT * FROM `gcg_users` 
					WHERE (user = '".$login_user."' or mail  = '".$login_user."') and pass = '".$login_pass."';";
			$resultado = $con->query($sql);
			$texto = '';

			if($resultado->num_rows > 0){

				while($row =  $resultado->fetch_assoc()){
					$texto = '{
						"id": '.$row['id'].',
						"mail": "'.$row['mail'].'",
						"user": "'.$row['user'].'",
						"avatar": "'.$row['avatar'].'"
					}';
				}

				echo '{"codigo":0,"mensaje":"Ejecución con éxito","respuesta":'.$texto.'}';
			} else {
				echo '{"codigo":1,"mensaje":"Usuario/Correo no existe o contraseña incorrectos","respuesta":null}';
			}

		} else  {
			echo '{"codigo":-1,"mensaje":"Datos incompletos","respuesta":null}';
		}
	}	
} catch (Exception $e){
	echo '{"codigo":1,"mensaje":"No se pudo registrar el usuario","respuesta":null}';
}
include '../footer.php';