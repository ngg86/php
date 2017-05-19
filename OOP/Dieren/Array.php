<?php

include "DierLibrary.php";
function randomNum()
{
	$num = rand(100,500);
	return $num;
}

$KoeArray = array();
$GeitArray = array();
$runder = new Koe(randomNum(), randomNum(), randomNum(), randomNum());
$geitje = new Geit(randomNum(), randomNum(), randomNum(), randomNum());
$aantalKoeien = 5;
$aantalGeiten = 10;
$babyGeit = 25;
$babyKoe = 15;

for($i=1; $i<$aantalKoeien; $i++)
{
	$KoeArray[] = $runder;
}

for($i=1; $i<$aantalGeiten; $i++)
{
	$GeitArray[] = $geitje;
}

for($i=1; $i<$babyGeit; $i++)
{
	$GeitArray[] = $geitje->Reproduceer();
}
for($i=1; $i<$babyKoe; $i++)
{
	$KoeArray[] = $runder->Reproduceer();
}

$Stal = array();
$Stal[] = $KoeArray;
$Stal[] = $GeitArray;

foreach($Stal as $DierArray)
{
	foreach($DierArray as $Dier)
	{
		if($Dier->)
	}
}


/*
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
*/

?>