<?php

function connect_database($database)
{
	$db = new mysqli('localhost', 'root','usbw',$database);
	return $db;
}

function dropdown()
{
	$db = connect_database('classicmodels');
	
	$sql_dropdown = "SELECT * FROM products";
	if(!$result = $db->query($sql_dropdown))
	{
		die($db->error);
	}
	while($data = $result->fetch_assoc())
	{
		echo "<option value=" . $data['productCode'] .">".$data['productName']."</option>";
	}
}
function makeProductArray()
{
	$code = $_POST['select'];
	$db = connect_database('classicmodels');
	
	$query = "SELECT * FROM products WHERE productCode = '$code'";
	if(!$result = $db->query($query))
	{
		die($db->error);
	}
	while($data = $result->fetch_assoc())
	{
		$product[] = $data;
	}
	return $product; 
}

	
function makeTable($product)
{
	
	foreach($product as $row)
	foreach($row as $index => $value)
	{
		
		echo "<tr><td align='center'><b>".$index."</b></td><td>".$value."</td></tr>";
		
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