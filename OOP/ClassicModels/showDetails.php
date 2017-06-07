<?php
include "functions.php";
$product = makeProductArray();
?>

<html>
	<head>
		<title> ShowDetails </title>
	</head>
	<style>
	table,tr,td{border:solid black 1px;border-collapse:collapse;}
	
	#tableTwo{position:realtive;}
	</style>
	<body>
		<div id=tableTwo>
		<table>
			<?php makeTable($product);?>
		</table>
		</div>
		<div id="here">
		</div>
	</body>
</html>