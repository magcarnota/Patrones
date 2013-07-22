<?php
/**
 * To implement by the Observer
 * 
 */
interface ObserverInterface
{
	/**
	 * When Observable object changes, calls $observer->onChange( $this );
	 * 
	 * @param ObservableInterface $sender
	 * @return void
	 */
	public function onChange( ObservableInterface $sender );
}

/**
 * To implement by observable element
 * 
 */
interface ObservableInterface
{
	/**
	 * Adds an Observer object to array of observers in Observable object
	 * 
	 * @param ObserverInterface $observer
	 * @return void
	 */
	public function addObserver( ObserverInterface $observer );
}

/**
 * Class Observable
 * 
 * @property private array $_observers array with observers
 * 
 */
class Observable implements ObservableInterface
{
	private $_observers;
	
	public function __construct()
	{
		$this->_observers = array();
	}
	
	/**
	 * Notifies each Observer on array $_observers calling $observer->onChange( $this )
	 * 
	 * @return void
	 * 
	 */
	public function notifyObservers()
	{
		foreach ( $this->_observers as $observer )
		{
			$observer->onChange( $this );
		}
	}
	
	public function addObserver( ObserverInterface $observer )
	{
		$this->_observers[] = $observer;
	}	
}

class ObserverOne implements ObserverInterface
{	
	public function onChange( ObservableInterface $sender )
	{
		echo "<p><b>".__CLASS__."</b> has been notified.</p>";
	}
}

class ObserverTwo implements ObserverInterface
{
	public function onChange( ObservableInterface $sender )
	{
		echo "<p><b>".__CLASS__."</b> has been notified.</p>";
	}
}

// TESTS
$observableObject = new Observable();					// New Observable object

$observableObject->addObserver( new ObserverOne() );	// Add ObserverOne
$observableObject->addObserver( new ObserverTwo() );	// Add ObserverTwo

$observableObject->notifyObservers();					// Notify all of observers on observableObject








