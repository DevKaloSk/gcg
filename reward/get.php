<?php
include '../header.php';
try {
	$con = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

	if (!$con) {
		echo '{"code":404,"message":"Error intentando conectar","data":null}';
	} else {

		if(isset($_POST['user'])) {

			$get_user = $_POST['user'];

			$sql = "SELECT R.* FROM `gcg_reward` as R
					LEFT OUTER JOIN (SELECT * FROM `gcg_reward_claimed` WHERE user_id = ".$get_user.") as RC on RC.reward_id = R.id 
					WHERE RC.user_id is null;";
			$resultado = $con->query($sql);
			$texto = '[';

			if($resultado->num_rows > 0){
				while($row =  $resultado->fetch_assoc()){
					$texto .= '{
						"ID": '.$row['id'].',
						"Name": "'.$row['name'].'",
						"Description": "'.$row['description'].'",
						"Extra": "'.$row['extra'].'",
						"Image": "'.$row['image'].'",
						"Formula": "'.$row['formula'].'",
						"Registered": "'.$row['registered'].'",
						"Active": '.$row['active'].'
					},';
				}
				$texto .= ']';
				$texto = str_replace(",]","]",$texto);
				echo '{"code":0,"message":"Ejecución con éxito","data":'.$texto.'}';
			} else {
				echo '{"code":1,"message":"No hay recompenzas por reclamar!","data":null}';
			}

		} else  {
			echo '{"code":-1,"message":"Datos incompletos","data":null}';
		}
	}	
} catch (Exception $e){
	echo '{"code":1,"message":"No se pudo obtener el usuario","data":null}';
}
include '../footer.php';