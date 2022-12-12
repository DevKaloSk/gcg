<?php
include '../../header.php';
try {
	$con = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

	if (!$con) {
		echo '{"code":404,"message":"Error intentando conectar","data":null}';
	} else {

		if(isset($_GET['id']) && isset($_GET['gems'])) {

			$manage_id = $_GET['id'];
			$manage_gems = $_GET['gems'];

			$sql = "UPDATE `gcg_users`
					SET
					gems = gems + '".$manage_gems."'
					WHERE id = '".$manage_id."';";
		
			if($con->query($sql)===TRUE){
				echo '{"code":0,"message":"Ejecución con éxito","data":null}';
			} else {
				echo '{"code":1,"message":"Error al actualizar las gemas","data":null}';
			}

		} else  {
			echo '{"code":-1,"message":"Datos incompletos","data":null}';
		}
	}	
} catch (Exception $e){
	echo '{"code":1,"message":"No se pudo actualizar el registro","data":null}';
}
include '../../footer.php';