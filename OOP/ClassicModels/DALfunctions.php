<?php

include "CMClassLibrary.php";
class ProductsDAL
{
    public static function GetProducts()
    {
        $db = new mysqli('localhost','root','usbw','classicmodels');
        $query = "SELECT * FROM products";
        if (!$resultaat = $db->query($query))
        {
           die($db->error);
        }
        $array = array();
        while($row = $resultaat->fetch_assoc())
        {
			$products = new CMProducts(
			$row["productCode"],
			$row["productName"],
			$row["productLine"],
			$row["productScale"],
			$row["productVendor"],
			$row["productDescription"],
			$row["quantityInStock"],
			$row["buyPrice"],
			$row["MSRP"]
		);
                
        array_push($array, $products);
		}
		return $array;
    }
	
	public static function InsertProduct($product)
	{
		$db = new mysqli('localhost','root','usbw','classicmodels');
		
		$newProduct = new CMProducts($product[0],
					$product[1],
					$product[2],
					$product[3],
					$product[4],
					$product[5],
					$product[6],
					$product[7],
					$product[8]);
		$query = 'INSERT INTO products ("productCode",
						"productName",
						"productLine",
						"productScale",
						"productVendor",
						"productDescription",
						"quantityInStock",
						"buyPrice",
						"MSRP") 
										
				VALUES ($product->pCode, 
						$product->pName, 
						$product->pLine, 
						$product->pScale, 
						$product->pVendor, 
						$product->pDescription, 
						$product->quantityInStock, 
						$product->buyPrice, 
						$product->MSRP);';

			if(!$resultaat = $db->query($query))
			{
				die($db->error);
			}						
		}
}





?>
