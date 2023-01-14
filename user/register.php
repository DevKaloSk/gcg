<?php
include '../header.php';
try {
	$con = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

	if (!$con) {
		echo '{"code":404,"message":"Error intentando conectar","data":null}';
	} else {

		if(isset($_POST['user']) && isset($_POST['pass']) && isset($_POST['mail']) && isset($_POST['connect_id'])) {

			$register_user = $_POST['user'];
			$register_pass = $_POST['pass'];
			$register_mail = $_POST['mail'];
			$register_coid = $_POST['connect_id'];

			$sql = "SELECT * FROM `gcg_users` 
			WHERE user = '".$register_user."' or mail = '".$register_mail."';";

			$results = $con->query($sql);

			if($results->num_rows == 0){

				$sql = "INSERT INTO `gcg_users` (`id`, `user`, `pass`, `mail`, `connect_id`) 
						VALUES (NULL, '".$register_user."', '".$register_pass."', '".$register_mail."', '".$register_coid."');";
			
				if($con->query($sql)===TRUE){

					$sql = "SELECT * FROM `gcg_users` 
							WHERE user = '".$register_user."' and mail = '".$register_mail."';";

					$results = $con->query($sql);
					$texto = '';

					if($results->num_rows > 0){
						while($row =  $results->fetch_assoc()){
							$texto = '{
								"ID": '.$row['id'].',
								"User": "'.$row['user'].'",
								"Nick": "'.$row['nick'].'",
								"Mail": "'.$row['mail'].'",
								"Avatar": "'.$row['avatar'].'",						
								"Description": "'.$row['description'].'",
								"Gold": '.$row['gold'].',
								"Gems": '.$row['gems'].',
								"ChangeName": '.$row['changeName'].',
								"DoneTutorial": '.$row['doneTutorial'].',
								"DoneFirstDeck": '.$row['doneFirstDeck'].',
								"Registered": "'.$row['registered'].'",
								"CharacterGems": '.$row['characterGems'].',
								"ArsenalGems": '.$row['arsenalGems'].',
								"MaxBox": '.$row['max_box'].'
							}';
						}
						echo '{"code":0,"message":"Ejecución con éxito","data":'.$texto.'}';
					} else {
						echo '{"code":1,"message":"Ocurrio un error al consultar los datos","data":null}';
					}

				} 
				else {
					echo '{"code":1,"message":"Ocurrio un error al registrar al usuario","data":null}';
				}

			} else {
				echo '{"code":1,"message":"Usuario y/o correo existen","data":null}';
			}

		} else  {
			echo '{"code":-1,"message":"Datos incompletos","data":null}';
		}
	}
} catch (Exception $e){
	echo '{"code":1,"message":"No se pudo registrar el usuario","data":null}';
}
include '../footer.php';