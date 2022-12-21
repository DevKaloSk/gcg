<?php
include '../header.php';
try {
	$con = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

	if (!$con) {
		echo '{"code":404,"message":"Error intentando conectar","data":null}';
	} else {

		if(isset($_POST['user']) && isset($_POST['name']) && isset($_POST['icon'])) {

			$register_user = $_POST['user'];
			$register_name = $_POST['name'];
			$register_icon = $_POST['icon'];

			$sql = "INSERT INTO `gcg_deck_box` (`id`, `user`, `name`, `icon`) 
					VALUES (NULL, ".$register_user.", '".$register_name."', '".$register_icon."');";

			if($con->query($sql)===TRUE){
				echo '{"code":0,"message":"Ejecución con éxito","data":null}';
			} else {
				echo '{"code":1,"message":"Error al registrar en la caja de barajas","data":null}';
			}

		} else  {
			echo '{"code":-1,"message":"Datos incompletos","data":null}';
		}
	}
} catch (Exception $e){
	echo '{"code":1,"message":"No se pudo registrar en la caja de barajas","data":null}';
}
include '../footer.php';