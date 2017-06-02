<?php

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
			$this->pDescription = $pDescription;
			$this->quantityInStock = $quantityInStock;
			$this->buyPrice = $buyPrice;
			$this->MSRP = $MSRP;
		}	
}		




?>