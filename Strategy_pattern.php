<?php
/**
 * Strategy interface
 *
 */
interface StrategyInterface
{
	/**
	 * Filters given $record
	 * 
	 * @param string $record
	 * @return boolean
	 */
	public function filter( $record );
}

/**
 * Finds $record after $this->_name;
 * 
 * @property private string $_name
 */
class FindAfterStrategy implements StrategyInterface
{
	private $_name;
	
	public function __construct( $name )
	{
		$this->_name = $name;
	}
	
	public function filter( $record )
	{
		return strcmp( $this->_name , $record ) <= 0;
	}
}

/**
 * Ramdom $record
 *
 */
class RandomStrategy implements StrategyInterface
{
	public function filter( $record )
	{
		return rand( 0 , 1 ) >= 0.5;
	}
}

/**
 * Finds elements in a list using StrategyInterface strategy
 * 
 * @property private array $_list
 */
class UserList
{
	private $_list;
	
	public function __construct( $names )
	{
		$this->_list = array();
		
		if ( !is_null( $names ) && is_array( $names ) )
		{
			foreach ( $names as $name )
			{
				$this->add( $name );
			}
		}
	}
	
	/**
	 * Adds string to $this->_list
	 * 
	 * @param string $name
	 */
	public function add( $name )
	{
		$this->_list[] = $name;
	}
	
	/**
	 * Applies $filter strategy on each element of the $this->_list
	 * 
	 * @param StrategyInterface $filter
	 * @return array
	 */
	public function find( StrategyInterface $filter )
	{
		$result = array();
		
		foreach ( $this->_list as $user )
		{
			if ( $filter->filter( $user ) ) {
				$result[] = $user;
			}
		}
		
		return $result;
	}
}

// TESTS

$userList = new UserList( array( "Soda" , "Cola" , "Water" , "Juice" ) );

$result = $userList->find( new FindAfterStrategy( "L" ) );
echo "<pre>";
print_r( $result );
echo "</pre>";

$result = $userList->find( new RandomStrategy() );
echo "<pre>";
print_r( $result );
echo "</pre>";























