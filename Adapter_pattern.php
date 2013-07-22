<?php
/**
 * Abstract class for being extended by EmailAddressDisplayAdapter
 * 
 * @property private string $_addressType
 * @property private string $_addressText
 *
 */
abstract class AddressDisplay
{
	private $_addressType;
	private $_addressText;
	
	/**
	 * Sets $this->_addressType
	 * 
	 * @param string $addressType
	 * @return void
	 * 
	 */
	public function setAddressType( $addressType )
	{
		$this->_addressType = $addressType;
	}
	
	/**
	 * Returns $this->_addressType
	 * 
	 * @return string
	 * 
	 */
	public function getAddressType()
	{
		return $this->_addressType;
	}
	
	/**
	 * Sets $this->_addressText
	 * 
	 * @param string $addressText
	 * @return void
	 * 
	 */
	public function setAddressText( $addressText )
	{
		$this->_addressText = $addressText;
	}
	
	/**
	 * Returns $this->_addressText
	 * 
	 * @return string
	 * 
	 */
	public function getAddressText()
	{
		return $this->_addressText;
	}
}

/**
 * Class EmailAddress
 * 
 * @property private string $_emailAddress
 *
 */
class EmailAddress
{
	private $_emailAddress;
	
	public function __construct( $email )
	{
		$this->_emailAddress = $email;
	}
	
	/**
	 * Returns $this->_emailAddress
	 * 
	 * @return string
	 * 
	 */
	public function getEmailAddress()
	{
		return $this->_emailAddress;
	}
}

/**
 * Extends AddressDisplay abstract class
 *
 */
class EmailAddressDisplayAdapter extends AddressDisplay
{	
	public function __construct( EmailAddress $emailAddress )
	{
		$this->setAddressType( "email" );
		$this->setAddressText( $emailAddress->getEmailAddress() );
	}
}

// TESTS

$email = new EmailAddress( "email@host.com" );						// new EmailAddress

$address = new EmailAddressDisplayAdapter( $email );				// new EmailAddressDisplayAdapter

echo "<p> Address Type: <b>".$address->getAddressType()."</b></p>";
echo "<p> Address Text: <b>".$address->getAddressText()."</b></p>";



