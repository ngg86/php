<?php
//ProductsDAL functions

function connect_database($database)
{
	$db = new mysqli('localhost', 'root','usbw',$database);
	return $db;
}

function getData($db)
{
	$sql_get = "SELECT * FROM products";
	if(!$result = $db->query($sql_get))
	{
		die($db->error);
	}
	while($data = $result->fetch_assoc())
	{
		$array[] = $data;
	}
	return $array;
}




?>
