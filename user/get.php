<?php
include '../header.php';
try {
	$con = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

	if (!$con) {
		echo '{"code":404,"message":"Error intentando conectar","data":null}';
	} else {

		if(isset($_POST['id'])) {

			$get_id = $_POST['id'];

			$sql = "SELECT * FROM `gcg_users` 
					WHERE id = '".$get_id."';";
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
				echo '{"code":1,"message":"Usuario no existe","data":null}';
			}

		} else  {
			echo '{"code":-1,"message":"Datos incompletos","data":null}';
		}
	}	
} catch (Exception $e){
	echo '{"code":1,"message":"No se pudo obtener el usuario","data":null}';
}
include '../footer.php';