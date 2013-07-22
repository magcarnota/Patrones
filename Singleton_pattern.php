<?php
/**
 * Connection class to a MySQL database with singleton pattern
 * 
 */

interface SingletonInterface
{
	public static function getInstance();
	public static function resetInstance();
	public function __clone();
	public function __wakeup();
}

class Connection implements SingletonInterface
{
	private static $_instance;
	private $_link;
	private $_creationTime;
	private static $_connection_data = array(	"HOST"		=>	"localhost",
												"USER"		=>	"root",
												"PASSWORD"	=>	"",
												"DATABASE"	=>	"test",
												"PORT"		=>	3306
										);

	private function __construct()
	{
		self::$_instance = $this;
		$this->_link = mysqli_connect( self::$_connection_data["HOST"] , 
											 self::$_connection_data["USER"] , 
											 self::$_connection_data["PASSWORD"] ,
											 self::$_connection_data["DATABASE"] ,
											 self::$_connection_data["PORT"] );
		$this->_creationTime = microtime( true );
	}
	
	public static function getInstance()
	{
		if ( !isset( self::$_instance ) )
		{
			new Connection();
		}
		
		return self::$_instance;
	}
	
	public static function resetInstance()
	{
		new Connection();
	}
	
	public function getConnection()
	{
		return $this->_link;
	}
	
	public function __clone()
	{
		throw new ErrorException("Impossible to clone a singleton object !");
	}
	
	public function __wakeup()
	{
		throw new ErrorException("Impossible to wakeup a singleton object !");
	}
}

echo "First attempt to get an instance: <br>";
$myConnection = Connection::getInstance();
echo "This is the link: <br>";
echo "<pre>";
print_r( $myConnection->getConnection() );
echo "</pre>";

echo "Second attempt to get an instance: <br>";
$myConnection2 = Connection::getInstance();
echo "This is the link: <br>";
echo "<pre>";
print_r( $myConnection2->getConnection() );
echo "</pre>";











