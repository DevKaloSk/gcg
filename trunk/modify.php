<?php
include '../header.php';
try {
	$con = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

	if (!$con) {
		echo '{"code":404,"message":"Error intentando conectar","data":null}';
	} else {

		if(isset($_POST['id']) && isset($_POST['avatar']) && isset($_POST['description'])) {

			$modify_id = $_POST['id'];
			$modify_avatar = $_POST['avatar'];
			$modify_description = $_POST['description'];

			$sql = "UPDATE `gcg_trunk`
					SET
					avatar = '".$modify_avatar."',
					description = '".$modify_description."'
					WHERE id = '".$modify_id."';";
		
			if($con->query($sql)===TRUE){
				echo '{"code":0,"message":"Ejecución con éxito","data":null}';
			} else {
				echo '{"code":1,"message":"Error al modificar usuario","data":null}';
			}

		} else  {
			echo '{"code":-1,"message":"Datos incompletos","data":null}';
		}
	}	
} catch (Exception $e){
	echo '{"code":1,"message":"No se pudo registrar el usuario","data":null}';
}
include '../footer.php';