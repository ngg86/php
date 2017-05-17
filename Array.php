<?php

include "DierLibrary.php";

$KoeArray = array();
$runder = new Koe(180,135,150,550);


for($i=0; $i<5; $i++)
{
	$KoeArray[] = $runder->Reproduceer();
	
}

foreach($KoeArray as $koe)
{
	echo "Naam: Koe_" . rand(00,99) . "<br>";
	echo "Lengte: " . $koe->lengte . "<br>";
	echo "Hoogte: " . $koe->hoogte . "<br>";
	echo "Breedte: " . $koe->breedte . "<br>";
	echo "Massa: " . $koe->massa . "<br>";
	$koe->MaakGeluid();
	echo "<br><br>";
}


?>