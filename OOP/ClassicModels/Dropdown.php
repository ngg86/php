<?php
include "functions.php";
?>

<html>
	<head>
		<title> Dropdown</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="ajaxDropDown.js"></script>
	</head>
	
	<body>
		<form method="post" action="showDetails.php">
			<p>
				Choose one...
			</p>
			<select name="select" id="drop"> <?php Dropdown(); ?> </select>
			<p>
			<br>
			</p>
<div id="here">
</div>			
		</form>
	</body>
</html>
		