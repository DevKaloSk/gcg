<?php
include '../header.php';
try {
	$con = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

	if (!$con) {
		echo '{"code":404,"message":"Error intentando conectar","data":null}';
	} else {

		if(isset($_POST['user']) && isset($_POST['type'])) {

			$get_user = $_POST['user'];
			$get_type = $_POST['type'];

			if($get_type==1) $sql = "SELECT R.id,R.name,R.description,R.image_box,R.image_icon,R.image_icon,R.pool,R.cost_coin,R.cost_gems,
									(R.quantity-IFNULL(RC.quantity,0)) as quantity,R.bg_color FROM `gcg_buy_decks` as R 
									LEFT OUTER JOIN (SELECT DISTINCT RSC.user_id,RSC.buy_id,RSC.type,SUM(RSC.quantity) as quantity
													FROM `gcg_users_purchases` as RSC 
													WHERE RSC.user_id = ".$get_user." and RSC.type = ".$get_type."
													GROUP BY RSC.user_id,RSC.buy_id,RSC.type) as RC 
													on RC.buy_id = R.id;";

			$results = $con->query($sql);
			$texto = '[';

			if($results->num_rows > 0){
				while($row =  $results->fetch_assoc()){
					$texto .= '{
						"ID": '.$row['id'].',
						"Name": "'.$row['name'].'",
						"Description": "'.$row['description'].'",
						"ImageBox": "'.$row['image_box'].'",
						"ImageIcon": "'.$row['image_icon'].'",
						"Pool": "'.$row['pool'].'",
						"CostCoin": '.$row['cost_coin'].',
						"CostGems": '.$row['cost_gems'].',
						"Quantity": '.$row['quantity'].',
						"BgColor": "'.$row['bg_color'].'"
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