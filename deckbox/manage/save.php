<?php
include '../../header.php';
try {
	$con = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

	if (!$con) {
		echo '{"code":404,"message":"Error intentando conectar","data":null}';
	} else {

		if(isset($_POST['id']) && isset($_POST['name']) && isset($_POST['icon']) && isset($_POST['clans']) && 
			isset($_POST['total_character']) && isset($_POST['total_arsenal']) && 
			isset($_POST['list_character']) && isset($_POST['list_arsenal'])) {

			$save_id = $_POST['id'];
			$save_name = $_POST['name'];
			$save_icon = $_POST['icon'];
			$save_clans = $_POST['clans'];
			$save_total_character = $_POST['total_character'];
			$save_total_arsenal = $_POST['total_arsenal'];
			$save_list_character = $_POST['list_character'];
			$save_list_arsenal = $_POST['list_arsenal'];

			$sql = "UPDATE `gcg_deck_box`
					SET
					name = '".$save_name."',
					icon = '".$save_icon."',
					clans = '".$save_clans."',
					total_character = ".$save_total_character.",
					total_arsenal = ".$save_total_arsenal.",
					list_character = '".$save_list_character."',
					list_arsenal = '".$save_list_arsenal."'
					WHERE id = '".$save_id."';";
		
			if($con->query($sql)===TRUE){
				echo '{"code":0,"message":"Ejecución con éxito","data":null}';
			} else {
				echo '{"code":1,"message":"Error al actualizar la baraja","data":null}';
			}

		} else  {
			echo '{"code":-1,"message":"Datos incompletos","data":null}';
		}
	}	
} catch (Exception $e){
	echo '{"code":1,"message":"No se pudo actualizar la baraja","data":null}';
}
include '../../footer.php';