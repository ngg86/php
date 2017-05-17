<?php

	class Dier
	{
		public $lengte;
		public $breedte;
		public $hoogte;
		public $massa;
		
		public function MaakGeluid()
		{
			echo "een geluid";
		}
	}
	
	
	
	class Vee extends Dier
	{
		public function __construct($lengte, $breedte, $hoogte, $massa)
		{
			//
			// php ' -> ' == c# '  .  ' 
			// php '$this->lengte' == c# 'this.lengte'
			//
			$this->lengte = $lengte;
			$this->breedte = $breedte;
			$this->hoogte = $hoogte;
			$this->massa = $massa;
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
	}


?>