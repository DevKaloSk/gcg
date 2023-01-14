<?php
include '../header.php';
try {
	$con = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

	if (!$con) {
		echo '{"code":404,"message":"Error intentando conectar","data":null}';
	} else {

		if(isset($_POST['user']) && isset($_POST['item']) && isset($_POST['quantity']) && isset($_POST['type']) && isset($_POST['currency'])) {

			$buy_user = $_POST['user'];
			$buy_item = $_POST['item'];
			$buy_type = $_POST['type'];
			$buy_quantity = $_POST['quantity'];
			$buy_currency = $_POST['currency'];

			if($buy_type==1) $sql = "SELECT * FROM `gcg_buy_decks` WHERE id = '".$buy_item."';";

			$results = $con->query($sql);
			$amount_gold = 0;
			$amount_gems = 0;
			$buy_content_pool = '';

			if($results->num_rows > 0){
				while($row =  $results->fetch_assoc()){
					$amount_gold = $row['cost_coin'];
					$amount_gems = $row['cost_gems'];
					$buy_content_pool = $row['pool'];
				}

				$sql = "SELECT * FROM `gcg_users` WHERE id = '".$buy_user."';";
				$results = $con->query($sql);

				$user_gold = 0;
				$user_gems = 0;

				if($results->num_rows > 0){
					while($row =  $results->fetch_assoc()){
						$user_gold = $row['gold'];
						$user_gems = $row['gems'];
					}					

					$amount_registered = 0;
					$can_user_buy = false;

					if($buy_currency==1) {
						$amount_registered = $amount_gold;
						if($user_gold>=$amount_gold) $can_user_buy = true;
					} else if($buy_currency==2) {
						$amount_registered = $amount_gems;
						if($user_gems>=$amount_gems) $can_user_buy = true;
					}

					if($can_user_buy){

						$sql = "INSERT INTO `gcg_users_purchases` (`user_id`, `buy_id`, `type`, `quantity`, `currency`, `amount`, `pool`) 
							VALUES (".$buy_user.", ".$buy_item .", ".$buy_type .", ".$buy_quantity .", ".$buy_currency .", ".$amount_registered .", '".$buy_content_pool ."');";

						if($con->query($sql)===TRUE){				

							if($buy_currency=='1') {

								$sql = "UPDATE `gcg_users`
										SET
										gold = gold - ".$amount_gold."
										WHERE id = '".$buy_user."';";
							
								if($con->query($sql)===TRUE){
									echo '{"code":0,"message":"Ejecución con éxito","data":null,"pool":"'.$buy_content_pool.'"}';
								} else {
									echo '{"code":1,"message":"Error al actualizar las monedas","data":null}';
								}

							} else if($buy_currency=='2') {

								$sql = "UPDATE `gcg_users`
										SET
										gems = gems - ".$amount_gems."
										WHERE id = '".$buy_user."';";
							
								if($con->query($sql)===TRUE){
									echo '{"code":0,"message":"Ejecución con éxito","data":null,"pool":"'.$buy_content_pool.'"}';
								} else {
									echo '{"code":1,"message":"Error al actualizar las gemas","data":null}';
								}

							} else {
								echo '{"code":1,"message":"Modo de pago no identificado","data":null}';
							}

						} else {
							echo '{"code":1,"message":"Error al registrar la compra","data":null}';
						}

					} else {
						echo '{"code":1,"message":"No hay suficiente saldo","data":null}';
					}					

				} else {
					echo '{"code":1,"message":"Usuario no existe","data":null}';
				}				

			} else {
				echo '{"code":1,"message":"Ocurrio un error al consultar la compra","data":null}';
			}

		} else  {
			echo '{"code":-1,"message":"Datos incompletos","data":null}';
		}
	}
} catch (Exception $e){
	echo '{"code":1,"message":"No se pudo registrar en la reclamación de premio","data":null}';
}
include '../footer.php';