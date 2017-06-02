<?php

function connect_database($database)
{
	$db = new mysqli('localhost', 'root','usbw',$database);
	return $db;
}

function dropdown()
{
	$db = connect_database('classicmodels');
	
	$sql_dropdown = "SELECT * FROM productLines";
	if(!$result = $db->query($sql_dropdown))
	{
		die($db->error);
	}
	while($data = $result->fetch_assoc())
	{
		echo "<option value=" . $data['productLine'] .">".$data['productLine']."</option>";
	}
}

function makeArray()
{
	$array = array(
	$_POST['prodCode'],
	$_POST['prodName'],
	$_POST['product'],
	$_POST['prodScale'],
	$_POST['prodVendor'],
	$_POST['prodDesc'],
	$_POST['prodQuantity'],
	$_POST['buyPrice'],
	$_POST['MSRP']);
	
	return $array;
}

function checkArray($array)
{
	foreach($array as $element)
	{
		if(empty($element))
		{
			echo "Some elements are empty!<br>";
		}
	}
}


?>