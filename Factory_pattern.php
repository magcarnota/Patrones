<?php
/**
 * Formats $className to 'Xxxx...x' ( First letter uppercase and remaining letters lowercase )
 * 
 * @param string $className
 * @return string
 */
function toClassName( $className )
{
	return 	trim( ucfirst( strtolower( $className ) ) );
}

/**
 * Interface for being implemented by ShapeFactory class
 * 
 * @method createShape
 * @method registerShape
 * @method unregisterShape
 * @method getRegisteredShapes
 */
interface FactoryInterface
{
	/**
	 * Creates an instance of given $shape class
	 * 
	 * @access public
	 * @param mixex a string or an array os strings
	 * @return mixed an instance of $shape on success or false otherwise
	 */
	static public function createShape( $shape );
	
	/**
	 * Register a new shape for ShapeFactory
	 * 
	 * @access public
	 * @param mixed $shape a string or an array of strings
	 * @return integer number of registered shapes
	 */
	static public function registerShape( $shape );
	
	/**
	 * Unregister an existing shape for ShapeFactory
	 *
	 * @access public
	 * @param mixed $shape a string or an array of strings
	 * @return integer number of unregistered shapes
	 */
	static public function unregisterShape( $shape );
	
	/**
	 * Obtains all registered shapes
	 * 
	 * @access public
	 * @return array registered shapes or an empty array
	 */
	static public function getRegisteredShapes();
}

/**
 * Implements FactoryInterface
 * 
 * @property private static array $registeredShapes
 */
class ShapeFactory implements FactoryInterface
{
	private static $registeredShapes = array();
	
	static public function createShape ( $shape )
	{
		try
		{
			$shape = toClassName( $shape );
			if ( is_string( $shape ) && in_array( $shape , self::$registeredShapes ) )
			{
				if ( class_exists( $shape ) )
				{
					return new $shape();
				}
				else
				{
					throw new Exception("Class $shape not found !");
				}
			}
			else
			{
				if ( is_string( $shape ) )
				{
					echo "Class <em>$shape</em> not registered !";
				}
				else
				{
					echo "Given parameter is not a string !";
				}
				return false;
			}
		}
		catch ( Exception $ex )
		{
			echo "Exception: ".$ex->getMessage();
			return false;
		}
	}
	
	static public function registerShape( $shape )
	{
		$registeredShapes = 0;
		
		if ( is_array( $shape ) )
		{
			foreach ( $shape as $element )
			{
				$element = toClassName( $element );
				if ( is_string( $element ) && !in_array( $element , self::$registeredShapes ) )
				{
					self::$registeredShapes[] = $element;
					$registeredShapes++;
				}
			}
		}
		else
		{
			$shape = toClassName( $shape );
			if ( is_string( $shape ) && !in_array( $shape , self::$registeredShapes ) )
			{
				self::$registeredShapes[] = $shape;
				$registeredShapes++;
			}
		}
		
		return $registeredShapes;
	}
	
	static public function unregisterShape( $shape )
	{
		$unregisteredShapes = 0;
		
		if ( is_array( $shape ) )
		{
			foreach ( $shape as $element )
			{
				$element = toClassName( $element );
				if ( is_string( $element ) && in_array( $element , self::$registeredShapes ) )
				{
					unset( self::$registeredShapes[ array_search( $element , self::$registeredShapes ) ] );
					$unregisteredShapes++;
				}
			}
		}
		else
		{
			$shape = toClassName( $shape );
			if ( is_string( $shape ) && in_array( $shape , self::$registeredShapes ) )
			{
				unset( self::$registeredShapes[ array_search( $shape , self::$registeredShapes ) ] );
				$unregisteredShapes++;
			}
		}
		
		return $unregisteredShapes;
	}
	
	static public function getRegisteredShapes()
	{
		return self::$registeredShapes;
	}
}

/**
 * Abstract class Shape for being extended by each particular shape
 * 
 * @property integer $numberOfSides
 * @method getNumberOfSides()
 */
abstract class Shape
{
	protected  $numberOfSides;
	
	/**
	 * Returns number of sides
	 * 
	 * @access public
	 * @return integer $numberOfSides
	 */
	public function getNumberOfSides()
	{
		return $this->numberOfSides;
	}
}

class Triangle extends Shape
{	
	public function __construct()
	{
		$this->numberOfSides = 3;
	}
}

class Square extends Shape
{
	public function __construct()
	{
		$this->numberOfSides = 4;
	}
}

class Pentagon extends Shape
{
	public function __construct()
	{
		$this->numberOfSides = 5;
	}
}


// TESTS

echo "Registering a Triangle:<br>";
ShapeFactory::registerShape( "Triangle" );
$myTriangle = ShapeFactory::createShape( "Triangle" );
echo "Number of triangle's sides: ".$myTriangle->getNumberOfSides()."<br>";

echo "Registering a Square and a Pentagon in an array:<br>";
ShapeFactory::registerShape( array( "Square" , "Pentagon" ) );
$mySquare = ShapeFactory::createShape( "Square" );
echo "Number of square's sides: ".$mySquare->getNumberOfSides()."<br>";
$myPentagon = ShapeFactory::createShape( "Pentagon" );
echo "Number of pentagon's sides: ".$myPentagon->getNumberOfSides()."<br>";

echo "Obtaining registered shapes: <br>";
print_r( ShapeFactory::getRegisteredShapes() );

echo "<br>Trying to create a non registered class Hexagon: <br>";
$myHexagon = ShapeFactory::createShape( "Hexagon" );

echo "<br>Trying to create a non defined registered class Circle: <br>";
ShapeFactory::registerShape( "Circle" );
$myCircle = ShapeFactory::createShape( "Circle" );

echo "Obtaining registered shapes: <br>";
print_r( ShapeFactory::getRegisteredShapes() );

echo "<br>Trying to unregister shape Circle: <br>";
echo "It has been unregistered ".ShapeFactory::unregisterShape( "Circle" )." shapes. <br>";

echo "Obtaining registered shapes after unregister Circle: <br>";
print_r( ShapeFactory::getRegisteredShapes() );

echo "<br>Trying to unregister all remaining shapes: <br>";
echo "It has been unregistered ".ShapeFactory::unregisterShape( ShapeFactory::getRegisteredShapes() )." shapes. <br>";

echo "Obtaining registered shapes after unregister all shapes: <br>";
print_r( ShapeFactory::getRegisteredShapes() );







