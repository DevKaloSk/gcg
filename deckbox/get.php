<?php
include '../header.php';
try {
	$con = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

	if (!$con) {
		echo '{"code":404,"message":"Error intentando conectar","data":null}';
	} else {

		if(isset($_POST['user'])) {

			$get_user = $_POST['user'];

			$sql = "SELECT * FROM `gcg_deck_box` 
					WHERE user = '".$get_user."';";
			$resultado = $con->query($sql);
			$texto = '[';

			if($resultado->num_rows > 0){
				while($row =  $resultado->fetch_assoc()){
					$texto .= '{
						"ID": '.$row['id'].',
						"User": "'.$row['user'].'",
						"Name": "'.$row['name'].'",
						"Icon": "'.$row['icon'].'"
					},';
				}
				$texto .= ']';
				$texto = str_replace(",]","]",$texto);
				echo '{"code":0,"message":"Ejecución con éxito","data":'.$texto.'}';
			} else {
				echo '{"code":1,"message":"El usuario no tiene cajas","data":null}';
			}

		} else  {
			echo '{"code":-1,"message":"Datos incompletos","data":null}';
		}
	}	
} catch (Exception $e){
	echo '{"code":1,"message":"No se pudo obtener las cajas","data":null}';
}
include '../footer.php';