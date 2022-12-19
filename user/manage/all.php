<?php
include '../../header.php';
try {
	$con = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

	if (!$con) {
		echo '{"code":404,"message":"Error intentando conectar","data":null}';
	} else {

		if(isset($_POST['id']) && isset($_POST['field']) && isset($_POST['value'])) {

			$manage_id = $_POST['id'];
			$manage_field = $_POST['field'];
			$manage_value = $_POST['value'];

			$sql = "UPDATE `gcg_users`
					SET
					".$manage_field." = '".$manage_value."'
					WHERE id = '".$manage_id."';";
		
			if($con->query($sql)===TRUE){
				echo '{"code":0,"message":"Ejecución con éxito","data":null}';
			} else {
				echo '{"code":1,"message":"Error al actualizar '.$manage_field.'","data":null}';
			}

		} else  {
			echo '{"code":-1,"message":"Datos incompletos","data":null}';
		}
	}	
} catch (Exception $e){
	echo '{"code":1,"message":"No se pudo actualizar el registro","data":null}';
}
include '../../footer.php';