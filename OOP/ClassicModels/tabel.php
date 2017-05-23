<?php

include "CMClassLibrary.php";
//$products = CMProducts::GetProducts();
?>
<html>
	<head>
	</head>
	
	<body>
	<?php
	$products = CMProducts::GetProducts();
	foreach($products as $item)
	{
		foreach($item as $row)
		{
			echo $row;
		}
	}
	?>
		
	
	
	</body>
</html>