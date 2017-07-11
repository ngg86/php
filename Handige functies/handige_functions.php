<?php
//verbinding met database
function connect_database()
{
	$db = new mysqli('localhost', 'root','usbw', 'fca');
	return $db;
}

//run query en gegevens binnen een array stoppen
function getArray($query)
{
	$db = connect_database();
	$sql = $query;
	if(!$result = $db->query($query))
	{
		die($db->error);
	}
	while($data = $result->fetch_assoc())
	{
		$array[] = $data;
		if(empty($array))
		{		
			die;
		}		
	}
	if(!empty($array))
	{
		return $array;
	}
}

//Vul een <table> element met data van database
function makeTable($array)
{
	if(!empty($array))
	{
		$table = "";
		foreach($array as $row)
		{
			$table .= "<tr>";
			foreach($row as $index)
			{
				//$var = $row['id'];
				//Binnen <td> element kan inline css komen (align=center)
				$table .= "<td>" . $index . "</td>";	
						
			}
			//mogelijkheid om een link toe te voegen aan het eind van elk rij
			//$table.= "<td><a href='pagina.php?var=" . $var . "'>Omschrijving</a>";
			$table .= "</tr>";
		}
		return $table;
	}
	else
	{
		echo "Gegevens niet opgehaald.";
		return;
	}	
}

//Function om Query te runnen en gegevens binnen een tabel te zetten
function select()
{
	$query = "SELECT * FROM table";
	$var = getArray($query);
	$table = makeTable($var);
	print $table;
	
}

//function om iets nieuws toe te voegen aan database
function insert()
{
	/*declare variables
	$var
	$var1
	$var2..
	*/
	
	
	$db = connect_database();
	
	//Insert query
	$sqlQuery = "INSERT INTO table (kolom1,kolom2, kolom3) VALUES ($var, $var1, $var2)";
	
	if(!$result = $db->query($sqlQuery))
	{
		die($db->error);
	}
	//redirect naar gekozen pagina
	header('Location: tabel-financien.php');
}

//Update function
function update()
{
	/*declare variables
	$var
	$var1
	$var2..
	*/
	
	
	$db = connect_database();
	
	//Update query
	$sqlQuery = "UPDATE table SET kolom1 = $var, kolom2 = $var1, kolom3 = $var2)";
	
	if(!$result = $db->query($sqlQuery))
	{
		die($db->error);
	}
	//redirect naar gekozen pagina
	header('Location: tabel-financien.php');
}

//function om html <select> element te vullen
function DropDown()
{
	$db = connect_database('');
	
	$query = "SELECT * FROM table";
	if(!$result = $db->query($query))
	{
		die($db->error);
	}
	while($data = $result->fetch_assoc())
	{
		echo "<option value=" . $data[''] .">".$data['']."</option>";
	}
}
?>