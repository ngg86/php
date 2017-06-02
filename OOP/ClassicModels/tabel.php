<?php

//include "CMClassLibrary.php";
include "functions.php";
include "DALfunctions.php";
if(isset($_POST['submit']))
{
	
	$products = makeArray();
	checkArray($products);
	ProductsDAL::InsertProduct($products);
	
	
	
}

?>
<html>
	<head>
	</head>
	
	<body>
		<div id='invoer'>
			<fieldset>
				<form action='?' method='post'>				
					<table>
						<tr>
							<td>Product Code</td><td><input type='text' name='prodCode'></td>
						</tr>
						<tr>
							<td>Product Name</td><td><input type='text' name='prodName'></td>
						</tr>
						<tr>
							<td>Product Line</td><td><select name='product'><?php dropdown();?></select></td>
						</tr>
						<tr>
							<td>Product Scale</td><td><input type='text' name='prodScale'></td>
						</tr>
						<tr>
							<td>Product Vendor</td><td><input type='text' name='prodVendor'></td>
						</tr>
						<tr>
							<td>Product Description</td><td><input type='text' name='prodDesc'></td>
						</tr>
						<tr>
							<td>Product Quantity</td><td><input type='text' name='prodQuantity'></td>
						</tr>
						<tr>
							<td>Product Buy Price</td><td><input type='text' name='buyPrice'></td>
						</tr>
						<tr>
							<td>Product MSRP</td><td><input type='text' name='MSRP'></td>
						</tr>
					</table>
					<input type='submit' name='submit' value='Submit'>
				</form>
			</fieldset>
		</div>	
		<table border=1>
			<tr>
				<th>Code</th>
				<th>Name</th>
				<th>Line</th>
				<th>Scale</th>
				<th>Vendor</th>
				<th>Description</th>
				<th>Quantity</th>
				<th>Buy Price</th>
				<th>MSRP</th>
			</tr>
			<?php
				$products = ProductsDAL::GetProducts();
	
				foreach($products as $item)
				{
					echo "<tr>";
					foreach($item as $row)
					{
						echo "<td>".$row."</td>";
					}
					echo "</tr>";
				}
		
			?>
		</table>
		</div>
		
	
	
	</body>
</html>