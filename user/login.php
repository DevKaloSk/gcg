<?php
include '../header.php';
try {
	$con = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

	if (!$con) {
		echo '{"code":404,"message":"Error intentando conectar","data":null}';
	} else {

		if(isset($_POST['user']) && isset($_POST['pass'])) {

			$login_user = $_POST['user'];
			$login_pass = $_POST['pass'];

			$sql = "SELECT * FROM `gcg_users` 
					WHERE (user = '".$login_user."' or mail  = '".$login_user."') and pass = '".$login_pass."';";
			$resultado = $con->query($sql);
			$texto = '';

			if($resultado->num_rows > 0){
				while($row =  $resultado->fetch_assoc()){
					$texto = '{
						"ID": '.$row['id'].',
						"User": "'.$row['user'].'",
						"Nick": "'.$row['nick'].'",
						"Mail": "'.$row['mail'].'",
						"Description": "'.$row['description'].'",
						"Gold": "'.$row['gold'].'",
						"Gems": "'.$row['gems'].'",
						"ChangeName": "'.$row['changeName'].'",
						"DoneTutorial": "'.$row['doneTutorial'].'",
						"DoneFirstDeck": "'.$row['doneFirstDeck'].'",
						"Registered": "'.$row['registered'].'",
						"Avatar": "'.$row['avatar'].'",
						"CharacterGems": "'.$row['characterGems'].'",
						"ArsenalGems": "'.$row['arsenalGems'].'"
					}';
				}
				echo '{"code":0,"message":"Ejecución con éxito","data":'.$texto.'}';
			} else {
				echo '{"code":1,"message":"Usuario/Correo no existe o contraseña incorrectos","data":null}';
			}

		} else  {
			echo '{"code":-1,"message":"Datos incompletos","data":null}';
		}
	}	
} catch (Exception $e){
	echo '{"code":1,"message":"No se pudo registrar el usuario","data":null}';
}
include '../footer.php';