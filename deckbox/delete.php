<?php
include '../header.php';
try {
	$con = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

	if (!$con) {
		echo '{"code":404,"message":"Error intentando conectar","data":null}';
	} else {

		if(isset($_POST['id']) && isset($_POST['user'])) {

			$register_id = $_POST['id'];
			$register_user = $_POST['user'];

			$sql = "DELETE FROM `gcg_deck_box`
					WHERE id = ".$register_id." and user = ".$register_user.";";

			if($con->query($sql)===TRUE){
				echo '{"code":0,"message":"Ejecución con éxito","data":null}';
			} else {
				echo '{"code":1,"message":"Error al eliminar la caja de baraja","data":null}';
			}

		} else  {
			echo '{"code":-1,"message":"Datos incompletos","data":null}';
		}
	}
} catch (Exception $e){
	echo '{"code":1,"message":"No se pudo eliminar la caja de baraja","data":null}';
}
include '../footer.php';