<?php
/**
 * Shipper interface
 *
 */
interface Shipper
{
	/**
	 * Delivers the package
	 * 
	 * @param Package $package
	 * @return void
	 * 
	 */
	public function deliver( Package $package );
}

/**
 * Truck shipper implements Shipper
 *
 */
class TruckShipper implements Shipper
{
	public function deliver( Package $package )
	{
		echo "<p>Package (".$package->getCode().") deliver by truck.</p>";
	}
}

/**
 * Rail shipper implements Shipper
 *
 */
class RailShipper implements Shipper
{
	public function deliver( Package $package )
	{
		echo "<p>Package (".$package->getCode().") deliver by rail.</p>";
	}	
}

/**
 * Shipping delegate implements Shipper
 *
 */
class ShippingDelegate implements Shipper
{
	public function deliver( Package $package )
	{
		if ( $package->getWeight() > 100 )
		{
			$this->useRail()->deliver( $package );
		}
		else
		{
			$this->useTruck()->deliver( $package );
		}
	}
	
	/**
	 * Uses TruckShipper to deliver the package
	 * 
	 * @return TruckShipper
	 */
	public function useTruck()
	{
		return new TruckShipper();
	}
	
	/**
	 * Uses RailShipper to deliver the package
	 * 
	 * @return RailShipper
	 */
	public function useRail()
	{
		return new RailShipper();
	}
}

/**
 * Package
 * 
 * @property private string $_code
 * @property private float $_weight
 *
 */
class Package
{
	private $_code;
	private $_weight;
	
	public function __construct( $code , $weight )
	{
		$this->_code = $code;
		$this->_weight = $weight;
	}
	
	/**
	 * Returns package's code
	 * 
	 * @return string
	 * 
	 */
	public function getCode()
	{
		return $this->_code;
	}
	
	/**
	 * Returns package's weight
	 * 
	 * @return float
	 * 
	 */
	public function getWeight()
	{
		return $this->_weight;
	}
}

// TESTS

$packages = array( new Package( "00001" , 500.0 ),
				   new Package( "00002" , 25.0 ),
				   new Package( "00003" , rand( 0.5 , 1000.0 ) ),
				   new Package( "009A3" , rand( 0.5 , 1000.0 ) )
);


$shipper = new ShippingDelegate();

foreach ( $packages as $package )
{
	$shipper->deliver( $package );
}













