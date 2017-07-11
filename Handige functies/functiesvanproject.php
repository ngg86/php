<?php
//check login gegevens met database (gebruikersnaam/wachtwoord)
//RENZO
function logincheck($naam, $password)
{
	session_start();
	$db = connect_database();
	$sql = "SELECT * FROM gebruikers WHERE gebruikersNaam = '$naam' AND wachtWoord = '$password'";
            
    if (!$resultaat = $db->query($sql)) 
    {
		die($db->error);
	}
	else 
	{
		$rows = $resultaat->num_rows;
		if ($rows == 1)
		{               
			while ($row = $resultaat->fetch_assoc())
			{
				$lines[] = $row;
			}
			foreach($lines as $data)
			{
				$level = $data['Level'];
			}
			
			$_SESSION["level"] = $level;
			$_SESSION["naam"] = $naam;
			echo "<meta http-equiv='refresh' content='0; url=welkom.php' />";
		}
		else 
		{
			echo "foute inlog";
		}
	}
}

function showDate()
{
	date_default_timezone_set('Europe/Amsterdam');
	setlocale(LC_ALL, "nld_NLD");
	echo "Het is <br>" . date('H:i:s d/m/Y');
}

function checkLogin($username, $pass)
{
	$db = connect_database();
	$naam = $db->real_escape_string($username);
	$password = $db->real_escape_string($pass);
	//$password = hash('sha512',$password);
	
	if(loginCheck($naam, $password))
	{
		header("Location: welkom.php");
		exit;
	}
	else
	{
		echo "Gebruikersnaam en/of wachtwoord onbekend.";
	}

}

function gebruiker()
{
	if($_SESSION['naam'] == 'admin')
	{
		echo "administrator.";
	}
	else
	{
		echo "gebruiker.";
	}
}

//Toon de laatstelogin datum en tijd
//Sla huidige login tijd/datum op in database
function getCurrentDate()
{
	date_default_timezone_set('Europe/Amsterdam');
	setlocale(LC_ALL, "nld_NLD");
	
	$date = date_create();
	$nieuwdatum = date_timestamp_get($date);
	return $nieuwdatum;
}

function updateDate($nieuwdatum)
{
	$db = connect_database();
	$query = "UPDATE loginDatum SET laatsteLogin = $nieuwdatum";
	if(!$result = $db->query($query))
	{
		die($db->error);
	}		
}
//toon datum/tijd van laatste login
function showLastLogin()
{
	$db = connect_database();
	$query = "SELECT laatsteLogin FROM logindatum";
	if(!$result = $db->query($query))
	{		

		die($db->error);
		
	}
	while($data = $result->fetch_assoc())
	{
		$time = date('H:i:s d/m/Y', $data['laatsteLogin']);
		$lastlogin = "Laatste login was: <br>" . $time . "<br>";
	}
	return $lastlogin;
}

//toon menu voor admin (alle links)
function showAdminMenu()
{
	$table = "";
	$table .= "<table><tr>";
	$table .= "<th><a href='toonleden.php'>View Leden</a></th>";
	$table .= "<th><a href='tabel-financien.php'>View Financien</a></th>";
	$table .= "<th><a href='tabelpagina-jarige.php'>Jarige Leden</a></th>";
	$table .= "<th><a href='tabelpagina-nietbetaalde.php'>Niet-betaalde Leden</a></th>";
	$table .= "<th><a href='tabelpagina-exleden.php'>Ex-Leden</a></th>";
	$table .= "<th><a href='invoerpagina-nieuweleden.php'>Nieuw Leden</a></th>";
	$table .= "<th><a href='logout.php'>Uitloggen</a></th>";
	$table .= "</tr></table>";
	print $table;
}

//submenu voor Financiën, alleen voor admin
function showAdminSubMenu()
{
	$table = "";
	$table .= "<table><tr>";
	$table .= "<th>Betalingen Tonen</th>";
	$table .= "<th>Financiën Tonen</th>";
	$table .= "<th>Financiën Toevoegen</th>";
	print $table;
}
//submenu voor Financiën, voor gebruikers
function showHTMLSubMenu()
{
	$table = "";
	$table .= "<table><tr>";
	$table .= "<th>Betalingen Tonen</th>";
	$table .= "<th>Financiën Tonen</th>";
	$table .= "</tr></table>";
	print $table;
}

//toon menu voor standaard gebruiker (alleen links naar tabellen)
function showHTMLMenu()
{
	$table = "";
	$table .= "<table><tr>";
	$table .= "<th><a href='toonleden.php'>View Leden</a></th>";
	$table .= "<th><a href='tabel-financien.php'>View Financien</a></th>";
	$table .= "<th><a href='tabelpagina-jarige.php'>Jarige Leden</a></th>";
	$table .= "<th><a href='tabelpagina-nietbetaalde.php'>Niet-betaalde Leden</a></th>";
	$table .= "<th><a href='tabelpagina-exleden.php'>Ex-Leden</a></th>";
	$table .= "<th><a href='logout.php'>Uitloggen</a></th>";
	$table .= "</tr></table>";
	print $table;
}

function toonMenu()
{
	if(!$_SESSION['naam'] == 'admin')
	{
		showHTMLMenu();
	}
	else if ($_SESSION['naam'] == 'admin')
	{
		showAdminMenu();
	}
}
//verbinding met database
function connect_database()
{
	$db = new mysqli('localhost', 'root','usbw', 'fca');
	return $db;
}


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

//select sql query om leden binnen array te stoppen
function selectLeden()
{
	$sqlSelectLeden = "SELECT * FROM leden";
	$leden = getArray($sqlSelectLeden);
	if(isset($_POST['toonAlles']))
	{				
		if($_SESSION['naam'] != 'admin')
		{
			$table = makeTable($leden);
			print $table;
		}
		else
		{
			$table = makeLidTable($leden);
			print $table;
		}
	}
}

//select sql query om fincancien te tonen binnen een tabel
function selectFinancien()
{
	$sqlSelectFinancien = "SELECT * FROM financien";
	$financen = getArray($sqlSelectFinancien);
	$table = makeTable($financen);
	print $table;
	
}

//select sql query om betalingen te tonen binnen een tabel
function selectBetalingen()
{
	$sqlSelectBetalingen = "SELECT * FROM financien WHERE donateur = 0";
	$betalingen = getArray($sqlSelectBetalingen);
	$table = makeTable($betalingen);
	print $table;
}

//select/where query om financien van competetief jaar te tonen
function selectCompetitiefJaar($datum, $datumb)
{
	$sqlCompetitiefJaar = "SELECT * FROM financien WHERE datumBetaald >= '$datumb' and datumBetaald <= '$datum'";
	$compJaar = getArray($sqlCompetitiefJaar);
	$table = makeTable($compJaar);
	print $table;
}

//Maak een tabel van toegevoegd array
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
					if($index == '1')
					{											
						$table.="<td>Ja</td>";
					}
					elseif($index =='0')
					{
						$table.="<td>Nee</td>";
					}
					else
					{
						$table .= "<td>" . $index . "</td>";	
					}			
			}
			$table .= "</tr>";
		}
		return $table;
	}
	else
	{
		echo "Gegevens niet opgehaald.";
		return $table;
	}
	
}

function showSeniors()
{
	
	if(isset($_POST['toonSenior']))
	{
		$query = "SELECT * FROM leden WHERE lidgroep = 'Senior'";
		$senior = getArray($query);
		$table = makeTable($senior);
		print $table;
	}
}

function showJuniors()
{
	if(isset($_POST['toonJunior']))
	{
		$query = "SELECT * FROM leden WHERE lidgroep = 'Junior'";
		$junior = getArray($query);
		$table = makeTable($junior);
		print $table;
	}
}

function makeLidTable($array)
{
	if(!empty($array))
	{		
		$table = "";
		foreach($array as $row)
		{
			$table .= "<tr>";
			foreach($row as $index)
			{
					if($index == '1')
					{											
						$table.="<td>Ja</td>";
					}
					elseif($index =='0')
					{
						$table.="<td>Nee</td>";
					}
					else
					{
						$table .= "<td>" . $index . "</td>";	
					}			
			}
			$table .= "<td><a href='bewerkenpagina-leden.php?lidid=".$row['id']."'>wijzigen</a></td>";
			$table .= "</tr>";
		}
		return $table;
	}
}

//insert query om nieuw financien gegevens in de database te voeren
//$array = gegevens van invoer velden ($_POST)
//als er lege velden zijn die ook NULL mag zijn, geef waarde 'NVT' of 'Anonymous' (behalve LidId)
function nieuwFinancien()
{
	$id = $_POST['lidid'];
	$soort = $_POST['soort'];
	$bedrijfsnaam = $_POST['bedrijfsnaam'];
	$contactnaam = $_POST['contactnaam'];
	$adres = $_POST['adres'];
	$contactnummer = $_POST['contactnummer'];
	$email = $_POST['email'];
	$bedrag = $_POST['bedrag'];
	$datumbetaald = $_POST['datumbetaald'];
	if(!empty($_POST['donateur'])) $donateur = '1'; else $donateur = '0';
	
	$array = array($id, $soort, $bedrijfsnaam, $contactnaam, $adres, $contactnummer, $email, $bedrag, $datumbetaald, $donateur);
	
	foreach($array as $kolom=>$value)
	{
		//checkt of bedrag ingevoerd is, zo niet; stop
		if($array[7] == '')
		{
			echo "Er is geen bedrag toegevoegd";
			header('location: nieuwefinance.php');
			break;			
		}
		//checkt of bedrag een getal is, zo niet; stop
		else if(!ctype_digit($array[7]))
		{
			echo "Ongeldig invoer bij veld 'Bedrag'.";
			header('location: nieuwefinance.php');
			break;
		}
		//checkt of lidId een interger is, zo niet; stop
		if(!ctype_digit($array[0]))
		{			
			echo "Lid ID moet een nummer zijn. Gebruik '10' als geen Lid ID bekend is.";
			header('location: nieuwefinance.php');
			break;
			
		}
		else if ($array[0] != 10)
		{
			$lidId = $array[0];
			$query = "SELECT id FROM Leden WHERE id = $lidId";
			if(!$result = $db->query($query))
			{
				echo "Lid Id bestaat niet.";
				die($db->error);
				header('location: nieuwefinance.php');
				break;
			}
		}
		//checkt of Contact Naam leeg is, zo wel; voer 'Anonymous' in
		else if($array[2] == '')
		{
			$array['contactNaam'] == 'Anonymous';
		}
		//checkt of de rest van de velden leeg zijn. Zo wel; voer 'Nvt' in
		else if($kolom == '')
		{
			$value == 'Nvt';
		}
	}
	
	$db = connect_database();
	//LidId mag null zijn
	$lidId = (int)$array[0];
	$soort = $array[1];	
	$bnaam = $array[2];	
	$cnaam = $array[3];	
	$adres = $array[4];
	$cnummer = (int)$array[5];
	$email = $array[6];
	$bedrag = (float)$array[7];
	$datumBetaald = $array[8];
	$donateur = $array[9];
	
	
	$sqlQuery = "INSERT INTO financien (lidId, soort, bedrijfsNaam, contactNaam, adres, contactNummer, Email, Bedrag, datumBetaald, Donateur) VALUES ($lidId, '$soort', '$bnaam', '$cnaam', '$adres', '$cnummer', '$email', '$bedrag', '$datumBetaald', $donateur)";
	
	if(!$result = $db->query($sqlQuery))
	{
		die($db->error);
	}
	
	header('Location: tabel-financien.php');
}

function checkFinanceInvoer()
{
	
	$donateur = 0;
	if(isset($_POST['NieuwFinance']))
	{
		if(isset($_POST['donateur']))
		{
			$donateur = 1;
		}
		
		nieuwFinancien($_POST['lidId'], $_POST['companyName'], $_POST['contactName'], $_POST['address'], $_POST['contactNumber'], $donateur, $_POST['email'], $_POST['amount'], $_POST['paidDate']);
	}

}

function checkLidInvoer()
{	
	if(isset($_POST['NieuwLid']))
	{
		nieuwLid($_POST['firstName'], $_POST['lastName'], $_POST['birthDate'], $_POST['address'], $_POST['contactNumber'], $_POST['lidgroep'], $_POST['email']);
		
	}
}

//insert query om nieuw lid toe te voegen aan database
function nieuwlid($vnaam, $anaam, $gdatum, $adres, $tele, $lgroep, $email)
{
	$array = array($vnaam, $anaam, $gdatum, $adres, $tele, $lgroep, $email);
	foreach($array as $kolom)
	{
		if(empty($kolom))
		{
			echo "Alle velden moeten ingevuld worden.";
			break;
		}		
	}
	$voorNaam = $array[0];	
	$achterNaam = $array[1];
	$geboorteDatum = $array[2];
	$adres = $array[3];
	$telefoon = $array[4];
	$lidGroep = $array[5];
	$email = $array[6];
	
	$db = connect_database();
	$query = "INSERT INTO Leden (voorNaam, achterNaam, geboorteDatum, Adres, contactNummer, lidGroep, Email, isActief) VALUES ('$voorNaam', '$achterNaam', '$geboorteDatum', '$adres', '$telefoon', '$lidGroep', '$email', 1)";
	
	if(!$result = $db->query($query))
	{
		die($db->error);
	}
	else
	{
		echo "Lid is succesvol toegevoegd.";
		//stuur gebruiker naar toonleden.php
		header("Refresh:3; url=toonleden.php", true, 303);
	}
}

function wijzigLid($id)
{
		
	$vnaam = $_POST['firstName'];
	$anaam = $_POST['lastName'];
	$adres = $_POST['address'];
	$tele = $_POST['contactNumber'];
	$gdatum = $_POST['birthDate'];
	$lgroep = $_POST['lidgroep'];
	$email = $_POST['email'];
	if(!empty($_POST['actief'])) $actief = '1'; else $actief = '0';
	if(!empty($_POST['betaald'])) $betaald = '1'; else $betaald = '0';
	$id = $_POST['id'];
	$array = array($vnaam, $anaam, $gdatum, $adres, $tele, $lgroep, $email, $actief, $betaald, $id);
			
	$voorNaam = $array[0];	
	$achterNaam = $array[1];
	$geboorteDatum = $array[2];
	$adres = $array[3];
	$telefoon = $array[4];
	$lidGroep = $array[5];
	$email = $array[6];
	$id = $array[9];
	//var_dump($array);
	$db = connect_database();
	$query = "UPDATE Leden SET voorNaam = '$voorNaam', achterNaam = '$achterNaam', geboorteDatum = '$geboorteDatum', Adres = '$adres', contactNummer = '$telefoon', lidGroep = '$lidGroep', Email = '$email', isActief = $actief, betaald = $betaald WHERE id = $id";
	if(!$result = $db->query($query))
	{
		die($db->error);
	}
	header('Location: toonleden.php');
}
//select/where query om jarige leden te tonen binnen een tabel
function selectJarigeLeden()
{	
    
	$query = "SELECT * FROM leden WHERE MONTH(geboorteDatum) = MONTH(NOW())";
	
	$jarige = getArray($query);
	$table = makeTable($jarige);
	if(empty($table))
	{
		echo "Geen leden zijn jarig.";
		return;
	}
	else
	{
		print $table;
	}
}

function nieuwFinancienButton()
{
	$form = "<form action='nieuwefinance.php'>";
	$form .= "<input type='submit' value='Financien invoeren'>";
	$form .= "</form>";
	print $form;
}
/*function checkJarigeVar($lidId)
{
	if(empty($lidId))
	{
		echo "Field is empty.";
		break;
	}
	else
	{
		selectJarigeLeden($lidId);
	}
}
*/

//select/where query om ex-leden te tonen binnen een tabel
function selectExLeden()
{
	$query = "SELECT * FROM Leden WHERE isActief = 0";
	$exLeden = getArray($query);
	$table = makeTable($exLeden);
	print $table;
}

//select/where query om niet-betaalde leden te tonen binnen een tabel
function selectNietBetaalde()
{
	$query = "SELECT * FROM Leden WHERE betaald = 0 AND isActief = 1";
	$nietBetaald = getArray($query);
	$table = makeTable($nietBetaald);
	print $table;
	
}

//Voorgemaakte sjabloon sturen naar geslecteerde leden (email)
function berichtSturenJarige()
{
	$query = "SELECT voorNaam, Email FROM leden WHERE MONTH(geboorteDatum) = MONTH(NOW())";
	$array = getArray($query);
	foreach($array as $data)
	{
		$name = $data['voorNaam'];
		$email = $data['Email'];
		$note = file_get_contents('../_html/jarigebrief.html');
		$note = str_replace("NAAM",$name,$note);
		//mail($email,"Gefeliciteerd",$note);
		$note = str_replace($name,"NAAM",$note);
	}
}

//Voorgemaakte sjabloon sturen naar geslecteerde leden (email)?
function berichtSturenExLeden()
{
	$query = "SELECT voorNaam, achterNaam, Email FROM leden WHERE isActief = 0";
	$array = getArray($query);
	foreach($array as $data)
	{
		$name = $data['voorNaam'];
		$name .= " ";
		$name .= $data['achterNaam'];
		$email = $data['Email'];
		$note = file_get_contents('../_html/exledenbrief.html');
		$note = str_replace("NAAM", $name, $note);
		//mail($email,"FCA brief", $note);
		$note = str_replace($name, "NAAM", $note);
	}
}

//Voorgemaakte sjabloon sturen naar geslecteerde leden (email)?
function berichtSturenNietBetaalde()
{
	$query = "SELECT voorNaam, achterNaam, Email FROM leden WHERE betaald = 0 AND isActief = 1";
	$array = getArray($query);
	foreach($array as $data)
	{
		$name = $data['voorNaam'];
		$name .= " ";
		$name .= $data['achterNaam'];
		$email = $data['Email'];
		$note = file_get_contents('../_html/herinnering.html');
		$note = str_replace("NAAM", $name, $note);
		//mail($email,"FCA Herinnering", $note);
		$note = str_replace($name, "NAAM", $note);
	}
}

//Set lid naar actief
function setActief($lidId)
{
	$db = connect_database;
	$query = "UPDATE Leden SET (isActief = 1) WHERE id = $lidId";
	if(!$result = $db->query($query))
	{
		die($db->error);
	}
}

//Set lid naar inactief
function setInActief($lidId)
{
	$db = connect_database;
	$query = "UPDATE Leden SET (isActief = 0) WHERE id = $lidId";
	if(!$result = $db->query($query))
	{
		die($db->error);
	}
}
function exLedenSubmit()
{
	echo "<input type='submit' name='SEND' value='Stuur bericht'>";
	if(isset($_POST['SEND']))
	{
		berichtSturenExLeden();
	}
}

function nietBetaaldeSubmit()
{
	echo "<input type='submit' name='SEND' value='Stuur bericht'>";
	if(isset($_POST['SEND']))
	{
		berichtSturenNietBetaalde();
	}
}
function jarigeSubmit()
{
	echo "<input type='submit' name='SEND' value='Stuur bericht'>";
	if(isset($_POST['SEND']))
	{
		CheckMaand();
	}
}
function CheckMaand()
{
	
    date_default_timezone_set('Europe/Amsterdam');
    setlocale(LC_ALL, "nld_nld");
    $huidigemaand = date("n");
    
    $db = connect_database();
    
    $sql = "SELECT maand FROM maandcheck WHERE id = 1";
            
    if (!$resultaat = $db->query($sql)) 
    {
        die('query kan niet worden uitgevoerd');
    }
    else 
	{
        $rows = $resultaat->num_rows;
        if ($rows == 1)
		{    
            while ($row = $resultaat->fetch_assoc())
			{
                $lines[] = $row;
            }
            foreach($lines as $data)
			{
                $maand = $data['maand'];
            }
        }
        else 
		{
            die("Iets fout gegaan.");
        }
    }

    if($huidigemaand == $maand)
	{
        echo "Mail is al gestuurd";
    }
    else 
	{        			
		berichtSturenJarige();
	}
}

function selectGegevens($ID)
{
	$query = "SELECT * FROM Leden WHERE id = $ID";
	$lid = getArray($query);
	return $lid;
}

function ledenDropdown()
{
	$db = connect_database();
	$query = "SELECT voorNaam, achterNaam, id FROM leden";
	if(!$result = $db->query($query))
	{
		die($db->error);
	}
	while($data = $result->fetch_assoc())
	{
		$naam = $data['voorNaam'] . " " . $data['achterNaam'];
		echo "<option value=" . $data['id'] .">".$naam."</option>";
	}
}

function selectDonateurs()
{
	$sqlSelectDonateurs = "SELECT * FROM financien WHERE donateur = 1";
	$betalingen = getArray($sqlSelectDonateurs);
	$table = makeTable($betalingen);
	print $table;
}

function selectAbonnementen()
{
	$sqlSelectAbo = "SELECT * FROM financien WHERE Soort = 'Abonnement'";
	$abo = getArray($sqlSelectAbo);
	$table = makeTable($abo);
	print $table;
}
?>