<?php

include "DierLibrary.php";

$runder = new Koe(rand(100, 150), rand(80, 120), rand(180, 250), rand(480, 550);
$KoeArray = array();

echo "<br><br>";
for($i=0; $i<4; $i++)
{
	$KoeArray[] = $runder;
}

foreach($KoeArray as $koe)
{
	echo "Lengte: " . $koe->lengte . "<br>";
	echo "Hoogte: " . $koe->hoogte . "<br>";
	echo "Breedte: " . $koe->breedte . "<br>";
	echo "Massa: " . $koe->massa . "<br>";
	echo "<br><br>";
}
?>