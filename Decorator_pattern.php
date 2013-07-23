<?php
interface AutomobileInterface
{
	/**
	 * Returns automobile cost
	 * 
	 * @return float $this->_cost
	 * 
	 */
	public function getAutomobileCost();
	
	/**
	 * Returns automobile features
	 * 
	 * @return string
	 * 
	 */
	public function getFeatures();
}

/**
 * Base automobile
 *
 * @property private float $_cost
 *
 */
class BaseAutomobileModel implements AutomobileInterface
{
	private $_cost;
	
	public function __construct( $cost )
	{
		$this->_cost = $cost;
	}
	
	public function getAutomobileCost()
	{
		return $this->_cost;
	}
	
	public function getFeatures()
	{
		return "Base";
	}
}

/**
 * Sport automobile
 * 
 * @property private float $_cost
 * @property private AutomobileInterface $_model
 *
 */
class SportAutomobileModel implements AutomobileInterface
{
	private $_cost;
	private $_model;

	public function __construct( AutomobileInterface $model )
	{
		$this->_cost = $model->getAutomobileCost() + 1000.0;
		$this->_model = $model;
	}
	
	public function getAutomobileCost()
	{
		return $this->_cost;
	}

	public function getFeatures()
	{
		return $this->_model->getFeatures()." - Sport";
	}
}

/**
 * Touring automobile
 *
 * @property private float $_cost
 * @property private AutomobileInterface $_model
 *
 */
class TouringAutomobileModel implements AutomobileInterface
{
	private $_cost;
	private $_model;
	
	public function __construct( AutomobileInterface $model )
	{
		$this->_cost = $model->getAutomobileCost() + 2000.0;
		$this->_model = $model;
	}

	public function getAutomobileCost()
	{
		return $this->_cost;
	}

	public function getFeatures()
	{
		return $this->_model->getFeatures()." - Touring";
	}
}

/**
 * Automobile
 * 
 * @property private AutomobileInterface $_model
 *
 */
class Automobile
{
	private $_model;
	
	public function getModel()
	{
		return $this->_model;
	}
	
	/**
	 * Sets $this->_model
	 * 
	 * @param AutomobileInterface $model
	 * @return void
	 * 
	 */
	public function setModel( AutomobileInterface $model )
	{
		$this->_model = $model;
	}
	
	/**
	 * Prints description
	 * 
	 * @return void
	 * 
	 */
	public function printDescription()
	{
		echo "<p>Cost: ".$this->_model->getAutomobileCost()."<br>Description: ".$this->_model->getFeatures()."</p>";
	}
}


// TESTS

$auto = new Automobile();

$model = new BaseAutomobileModel( 500.0 );			// Base automobile
echo "<p>Cost: ".$model->getAutomobileCost()."<br>Features: ".$model->getFeatures()."</p>";

$model = new SportAutomobileModel( $model );		// Sport automobile (+ base automobile)
echo "<p>Cost: ".$model->getAutomobileCost()."<br>Features: ".$model->getFeatures()."</p>";

$model = new TouringAutomobileModel( $model );		// Touring automobile (+ sport automobile + base automobile)
echo "<p>Cost: ".$model->getAutomobileCost()."<br>Features: ".$model->getFeatures()."</p>";

$auto->setModel( $model );			// Sets our automobile
$auto->printDescription();			// Print description



















