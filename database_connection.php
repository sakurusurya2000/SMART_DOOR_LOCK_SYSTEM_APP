<?php

//database_connection.php

$connect = new PDO("mysql:host=localhost;dbname=smart_door_lock","root","");

$base_url = "http://localhost/smart_door/";

function get_total_records($connect, $table_name)
{
	$query = "SELECT * FROM $table_name";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}

function load_category_list($connect)
{
	$query = "
	SELECT * FROM tbl_category ORDER BY category_name ASC
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<option value="'.$row["category_id"].'">'.$row["category_name"].'</option>';
	}
	return $output;
}

function Get_category_name($connect, $cotegory_id)
{
	$query = "
	SELECT category_name FROM tbl_category 
	WHERE category_id = '".$category_id."'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return $row["category_name"];
	}
}

?>