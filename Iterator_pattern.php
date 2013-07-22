<?php
/**
 * Interface PlayersIterator
 *
 */
interface PlayersIterator
{
	/**
	 * Checks if exists next player
	 * 
	 * @return boolean
	 * 
	 */
	public function hasNext();
	
	/**
	 * Gets next player ( if exists )
	 * 
	 * @return string
	 * 
	 */
	public function next();
}

/**
 * Implements PlayersIterator
 * 
 * @property private array $_players
 * @property private integer $_position
 *
 */
class Team implements PlayersIterator
{
	private $_players;
	private $_position;
	
	public function __construct( $players )
	{
		$this->_players = $players;
		$this->_position = 0;
	}
	
	public function hasNext()
	{
		if ( $this->_position >= count( $this->_players )
			 || is_null( $this->_players[ $this->_position ] ) )
		{
			return false;
		}
		else
			return true;
	}
	
	public function next()
	{
		if ( $this->hasNext() )
		{
			return $this->_players[ $this->_position++ ];	// Attention: $this->_position++
		}
	}
}

// TESTS

$team = new Team( array( "Larry Bird" , "Michael Jordan" , "Pat Ewyn" , "Magic Johnson" ) );	// new Team

echo "<p>These are our players: </p>";
while( $team->hasNext() )
{
	echo "<p>".$team->next()."</p>";
}










