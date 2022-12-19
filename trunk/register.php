<?php
include '../header.php';
try {
	$con = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

	if (!$con) {
		echo '{"code":404,"message":"Error intentando conectar","data":null}';
	} else {

		if(isset($_POST['user']) && isset($_POST['card']) && isset($_POST['type']) && isset($_POST['quantity'])) {

			$register_user = $_POST['user'];
			$register_card = $_POST['card'];
			$register_type = $_POST['type'];
			$register_quantity = $_POST['quantity'];

			$sql = "SELECT * FROM `gcg_trunk` 
			WHERE user = '".$register_user."' and card  = '".$register_card."';";
			$resultado = $con->query($sql);

			if($resultado->num_rows > 0){
				if($register_type==0) {
					$sql = "UPDATE `gcg_users`
							SET
							characterGems = characterGems + ".$register_quantity."
							WHERE id = ".$register_user.";";
				
					if($con->query($sql)===TRUE){
						echo '{"code":0,"message":"Ejecución con éxito","data":null}';
					} else {
						echo '{"code":1,"message":"Error al actualizar gemas de personaje","data":null}';
					}
				} else {
					$sql = "UPDATE `gcg_trunk`
							SET
							quantity =  quantity + ".$register_quantity."
							WHERE user = ".$register_user." and card = '".$register_card."';";

					if($con->query($sql)===TRUE){
						echo '{"code":0,"message":"Ejecución con éxito","data":null}';						
					} else {
						echo '{"code":1,"message":"Error al actualizar el baul","data":null}';
					}
				}
				
			} else {
				$sql = "INSERT INTO `gcg_trunk` (`id`, `user`, `card`, `type`, `quantity`) 
						VALUES (NULL, ".$register_user.", '".$register_card."', ".$register_type.", ".$register_quantity.");";
				if($con->query($sql)===TRUE){
					echo '{"code":0,"message":"Ejecución con éxito","data":null}';
				} else {
					echo '{"code":1,"message":"Error al registrar en el baul","data":null}';
				}
			}

		} else  {
			echo '{"code":-1,"message":"Datos incompletos","data":null}';
		}
	}
} catch (Exception $e){
	echo '{"code":1,"message":"No se pudo registrar en el baul","data":null}';
}
include '../footer.php';