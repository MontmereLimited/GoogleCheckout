<?php

namespace GoogleCheckout;

class Item {
	
	/**
	 * Configuration array, set using the constructor or using ::setConfig()
	 *
	 * @var array
	 */
	protected $config = array(
		'item_name'			=> null,
		'item_description'	=> null,
		'unit_price'		=> null,
		'quantity'			=> null,
	);
	
	
	public function __construct($config = array()) {
		$this->setOptions($config);
	}
	
	/**
	 * Set Price
	 * 
	 * @param string $price
	 * @throws InvalidArgumentException
	 * @return Item
	 */
	public function setPrice($price) {
		if (!is_string($price) || !filter_var($price, FILTER_VALIDATE_FLOAT)) {
			throw new InvalidArgumentException("Must provide a string for a numeric value for price");
		}
		$this->config['unit_price'] = $price;
		return $this;
	}
	
	/**
	 * Set item name
	 * 
	 * @param string $name
	 * @return Item
	 */
	public function setName($name) {
		$this->config['item_name'] = $name;
		return $this;
	}
	
/**
	 * Set item name
	 * 
	 * @param string $name
	 * @return Item
	 */
	public function setDescription($description) {
		$this->config['item_description'] = $description;
		return $this;
	}
	
	/**
	 * Set quantity
	 * 
	 * @param int $qty
	 * @throws InvalidArgumentException
	 * @return Item
	 */
	public function setQuantity($qty) {
		if (!is_int($qty)) {
			throw new InvalidArgumentException("Must provide an integer for quantity");
		}
		$this->config['quantity'] = $qty;
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getPrice() {
		return $this->config['unit_price'];
	}
	
	/**
	 * @return string
	 */
	public function getName() {
		return $this->config['item_name'];
	}
	
	/**
	 * @return string
	 */
	public function getDescription() {
		return $this->config['item_description'];
	}
	
	/**
	 * @return int
	 */
	public function getQuantity() {
		return $this->config['quantity'];
	}
	
	
	/**
	 * Set configuration parameters
	 *
	 * @param  Zend_Config | array $config
	 * @return Order
	 * @throws Exception
	 */
	public function setOptions($config = array()) {
		if ($config instanceof \Zend_Config) {
			$config = $config->toArray();
		} elseif (!is_array($config)) {
			throw new Exception('Array or Zend_Config object expected, got ' . gettype($config));
		}
		
		foreach ($config as $k => $v) {
			$this->config[strtolower($k)] = $v;
		}
		
		return $this;
	}
	
	public function getOptions() {
		return $this->config;
	}
	
	/**
	 * @return bool
	 */
	public function isValid() {
		return $this->_validItem($this);
	}

	/**
	 * 
	 * @param Item $item
	 * @return bool
	 * @throws Exception
	 */
	protected function _validItem(Item $item) {
		foreach ($item->getOptions() as $key => $val) {
			if ($val === null) {
				return false;
			}
		}
		return true;
	}
	
	
}

