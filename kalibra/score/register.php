<?php
include '../../header.php';
try {
	$con = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

	if (!$con) {
		echo '{"code":404,"message":"Error intentando conectar","data":null}';
	} else {

		if(isset($_POST['name']) && isset($_POST['level']) && isset($_POST['score'])) {

			$register_name = $_POST['name'];
			$register_level = $_POST['level'];
			$register_score = $_POST['score'];

			$sql = "INSERT INTO `gcg_kalibra_scores` (`name`, `level`, `score`) 
					VALUES ('".$register_name."', ".$register_level.", ".$register_score.");";

			if($con->query($sql)===TRUE){
				echo '{"code":0,"message":"Se publico sus resultados con éxito","data":null}';
			} else {
				echo '{"code":1,"message":"Error al registrar el puntaje en kalibra","data":null}';
			}

		} else  {
			echo '{"code":-1,"message":"Datos incompletos","data":null}';
		}
	}
} catch (Exception $e){
	echo '{"code":1,"message":"No se pudo registrar el puntaje en kalibra","data":null}';
}
include '../../footer.php';