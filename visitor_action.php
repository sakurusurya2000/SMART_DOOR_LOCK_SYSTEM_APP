<?php
include('database_connection.php');

session_start();

if(isset($_POST["action"]))
{
	if($_POST["action"] == "index_fetch")
	{
		$query = "
		SELECT * FROM tbl_visitor 
		left JOIN tbl_member 
		ON tbl_visitor.authorized_id = tbl_member.authorized_id 
		";
		if(isset($_POST["search"]["value"]))
		{
			$query .= '
			WHERE tbl_member.member_name LIKE "%'.$_POST["search"]["value"].'%" 
			OR tbl_visitor.authorized_id LIKE "%'.$_POST["search"]["value"].'%" 
			';
		}
		if(isset($_POST["order"]))
		{
			$query .= '
			ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].'
			';
		}
		else
		{
			$query .= '
			ORDER BY tbl_visitor.authorized_id DESC 
			';
		}
		if($_POST["length"] != -1)
		{
			$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}

		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		$data = array();
		$filtered_rows = $statement->rowCount();
		foreach($result as $row)
		{
			$sub_array = array();
			$sub_array[] = '<img src="member_image/'.$row["member_image"].'" class="img-thumbnail" width="75" />';
			$sub_array[] = $row["member_name"];
			$sub_array[] = $row["authorized_id"];
			$sub_array[] = $row['visitor_status'];
			$sub_array[] = $row["visit_date"];
			$sub_array[] = '<button type="button" name="delete_member" class="btn btn-danger btn-sm delete_member" id="'.$row["visitor_id"].'">Delete</button>';
			$data[] = $sub_array;
		}
		$output = array(
			"draw"				=>	intval($_POST["draw"]),
			"recordsTotal"		=> 	$filtered_rows,
			"recordsFiltered"	=>	get_total_records($connect, 'tbl_visitor'),
			"data"				=>	$data
		);
		echo json_encode($output);

	}

	if($_POST["action"] == "delete")
	{
		$query = "
		DELETE FROM tbl_visitor 
		WHERE visitor_id = '".$_POST["visitor_id"]."'
		";
		$statement = $connect->prepare($query);
		if($statement->execute())
		{
			echo 'Data Deleted Successfully';
		}
	}
}
	?>
