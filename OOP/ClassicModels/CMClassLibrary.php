<?php
include "DALfunctions.php";

//$db = connect_database('classicmodels');
//$array = getData($db);
class CMProducts
{
	public $pCode;
	public $pName;
	public $pLine;
	public $pScale;
	public $pVendor;
	public $pDescription;
	public $quantityInStock;
	public $buyPrice;
	public $MSRP;
	
	public function __construct($pCode, $pName, $pLine, $pScale, $pVendor, $pDescription, $quantityInStock, $buyPrice, $MSRP)
		{
			$this->pCode = $pCode;
			$this->pName = $pName;
			$this->pLine = $pLine;
			$this->pScale = $pScale;
			$this->pVendor = $pVendor;
			$this->pScale = $pScale;
			$this->quantityInStock = $quantityInStock;
			$this->buyPrice = $buyPrice;
			$this->MSRP = $MSRP;
		}				


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
	
}




?>