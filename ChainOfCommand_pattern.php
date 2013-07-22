<?php
/**
 * Interface for commands
 *
 */
interface CommandInterface
{
	/**
	 * Checks if this is the command given by $name and echoes a message
	 * 
	 * @param string $name
	 * @param string $args
	 * @return bool
	 */
	public function onCommand( $name , $args );
}

class CommandOne implements CommandInterface
{
	public function onCommand( $name , $args )
	{
		if ( $name === __CLASS__ )
		{
			echo "<p><b>".__CLASS__."</b> handling command with args <i>$args</i></b></p>";
			return true;
		}
		else
			return false;
	}
}

class CommandTwo implements CommandInterface
{
	public function onCommand( $name , $args )
	{
		if ( $name === __CLASS__ )
		{
			echo "<p><b>".__CLASS__."</b> handling command with args <i>$args</i></b></p>";
			return true;
		}
		else
			return false;
	}
}

/**
 * Stores an array of commands
 * 
 * @property array CommandInterface $_commands
 *
 */
class CommandChain
{
	private $_commands;
	
	public function __construct()
	{
		$this->_commands = array();
	}
	
	/**
	 * Adds a command to $this->_commands array
	 * @param CommandInterface $command
	 * @return void
	 */
	public function addCommand( CommandInterface $command )
	{
		$this->_commands[] = $command;
	}
	
	/**
	 * Runs onCommand() on each command of $this_commands array
	 * 
	 * @param string $name
	 * @param string $args
	 * @return boolean
	 */
	public function runCommand( $name , $args )
	{
		foreach ( $this->_commands as $command )
		{
			if ( $command->onCommand( $name , $args ) )
				return true;
		}
		echo "<p>Command <b>$name</b> not found !</p>";
		return false;
	}
}

// TESTS

$commandChain = new CommandChain();

$commandChain->addCommand( new CommandOne() );
$commandChain->addCommand( new CommandTwo() );

$commandChain->runCommand( 'CommandTwo' , 'args for CommandTwo' );
$commandChain->runCommand( 'CommandOne' , 'args for CommandOne' );

$commandChain->runCommand( 'OtherCommand' , 'args for OtherCommand' );








