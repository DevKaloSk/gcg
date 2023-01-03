<?php
include '../header.php';
try {
	$con = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

	if (!$con) {
		echo '{"code":404,"message":"Error intentando conectar","data":null}';
	} else {

		if(isset($_POST['reward']) && isset($_POST['user'])) {

			$register_reward = $_POST['reward'];
			$register_user = $_POST['user'];

			$sql = "INSERT INTO `gcg_reward_claimed` (`reward_id`, `user_id`) 
					VALUES (".$register_reward.", ".$register_user.");";

			if($con->query($sql)===TRUE){
				echo '{"code":0,"message":"Ejecución con éxito","data":null}';
			} else {
				echo '{"code":1,"message":"Error al registrar la reclamación de premio","data":null}';
			}

		} else  {
			echo '{"code":-1,"message":"Datos incompletos","data":null}';
		}
	}
} catch (Exception $e){
	echo '{"code":1,"message":"No se pudo registrar en la reclamación de premio","data":null}';
}
include '../footer.php';