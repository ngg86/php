<?php

	abstract class Dier
	{
		public $lengte;
		public $breedte;
		public $hoogte;
		public $massa;
		
		public function MaakGeluid()
		{
			echo "...";
		}
		
		abstract function Reproduceer();
	}
	
	
		
	class Koe extends Dier
	{
		public function __construct($lengte, $massa)
		{
			$this->lengte = $lengte;			
			$this->massa = $massa;
			
		}
		public function __get($name)
		{
			switch ($name)
			{
				case 'lengte' :
					return $this->lengte;
					break;
				case 'massa' :
					return $this->massa;
					break;
			}
		}
		public function __set($name, $value)
		{
			switch($name)
			{
				case 'lengte' :
					if($value >= 0)
						$this->lengte($value);
						break;
				case 'massa' :
					if($value >= 0)
						$this->massa($value);
						break;
			}
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
	
	class Geit extends Dier
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
			echo "Mekker!";
		}
		
		public function Reproduceer()
		{
			$newgeit = new Geit(rand(60,120), rand(40,80), rand(45, 90), rand(50, 90));
			return $newgeit;
		}
	}


?>