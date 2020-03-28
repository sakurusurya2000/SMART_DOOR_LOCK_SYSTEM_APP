<?php
include('database_connection.php');
if($_SERVER['REQUEST_METHOD'] === "GET"){
		//$data = json_decode(file_get_contents("php://input"));
		//$param =json_decode(file_get_contents("php://input"));
		$authorized_id = isset($_GET['authorized_id'])? $_GET['authorized_id'] : "";

		if(!empty($authorized_id))
		{
			 $authorized_data = htmlspecialchars(strip_tags($authorized_id));

		$data = array(
					':authorized_id'			=>	$authorized_data,
					':visitor_status'		=>  'visited'
				);
				$query = "
		INSERT INTO tbl_visitor 
				(visitor_status, authorized_id) values (:visitor_status, :authorized_id)
				";
				$statement = $connect->prepare($query);
				if($statement->execute($data))
				{
					if($statement->rowCount() > 0)
					{
						echo"Visitor entered Successfully";
					}
					else
					{
						echo"Something wrong";
					}
				}
			}else{
				echo"Parameter is empty";
			}
		}
		else{
			echo"unauthorized";
		}



?>