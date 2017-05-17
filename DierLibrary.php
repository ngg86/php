<?php

	class Dier
	{
		public $lengte;
		public $breedte;
		public $hoogte;
		public $massa;
		
		public function MaakGeluid()
		{
			echo "...";
		}
		
		public function Reproduceer()
		{
		}
	}
	
	
		
	class Koe extends Dier
	{
		public function __construct($lengte, $breedte, $hoogte, $massa)
		{
			$this->lengte = $lengte;
			$this->breedte = $breedte;
			$this->hoogte = $hoogte;
			$this->massa = $massa;
			
		}
		
		public function MaakGeluid()
		{
			echo "Boe!";
		}	

		public function Reproduceer()
		{
			$newkoe = new Koe(rand(100,150),rand(80,120), rand(80,150), rand(400,550));
			return $newkoe;
		}
	}


?>