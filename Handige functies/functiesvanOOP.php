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

function dropdownEmployees()
{
	$db = connect_database('classicmodels');
	
	$sql_dropdown = "SELECT * FROM employees WHERE jobTitle = 'Sales Rep'";
	if(!$result = $db->query($sql_dropdown))
	{
		die($db->error);
	}
	while($data = $result->fetch_assoc())
	{
		$fullName = $data['firstName'];
		$fullName .= " ";
		$fullName .= $data['lastName'];
		echo "<option value=" . $data['employeeNumber'] .">".$fullName."</option>";
	}
}


function GetCustomers()
{
	$code = $_POST['select'];
	$db = connect_database('classicmodels');
	
	$query = "SELECT customerNumber, customerName, contactFirstName, contactLastName FROM customers WHERE salesRepEmployeeNumber = '$code'";
	if(!$result = $db->query($query))
	{
		die($db->error);
	}
	while($data = $result->fetch_assoc())
	{
		$product[] = $data;
	}
	if(empty($product))
	{
		echo "This employee has no customers.";
	}
	else
	return $product;
	
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

function makeCustomerTable($customer)
{
	if(empty($customer))
		return;
	foreach($customer as $row)
	{
		echo "<tr>";
	
		foreach($row as $index)
		{
			$num = $row['customerNumber'];
			echo "<td>" . $index . "</td>";
		}
		echo "<td><a href='orders.php?customer=".$num."'>Orders</a>";
		echo "</tr>";
				
	}
}

function makeOrderTable($orders)
{
	foreach($orders as $details)
	{
		echo "<tr id='".$details['orderNumber']."'>";
		foreach($details as $index)
		{
			echo "<td>" . $index . "</td>";			
		}
		echo "</tr>";
	}
}

function GetOrders()
{
	$code = $_GET['customer'];
	$db = connect_database('classicmodels');
	
	$query = "SELECT orderNumber, orderDate, requiredDate, shippedDate, status FROM orders WHERE customerNumber = '$code'";
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

function getDetails($orderNumber)
{
	$db = connect_database('classicmodels');
	
	$query = "SELECT * FROM orderDetails WHERE orderNumber = $orderNumber";
	if(!$result = $db->query($query))
	{
		die($db->error);
	}
	while($data = $result->fetch_assoc())
	{
		$order[] = $data;
	}
	return $order;
}

function makeDetailsTable($order)
{
	echo "<table>";
	foreach($order as $details)
	{
		echo "<tr>";
		foreach($details as $info)
		{
			echo "<td>" .$info."</td>";
		}
		echo "</tr>";
	}
	echo "</table>";
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