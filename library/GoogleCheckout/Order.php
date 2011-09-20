<?php

namespace GoogleCheckout;

class Order {

	/**
	 * @var array[int]Item
	 */
	protected $_items = array();

	/**
	 * Configuration array, set using the constructor or using ::setConfig()
	 *
	 * @var array
	 */
	protected $config = array(
		'merchant_id'		=> null,
		'merchant_key'		=> null,
		'callback_url'		=> null,
		'checkout_server'	=> 'https://sandbox.google.com/checkout',
	);
	
	
	public function __construct($config = array()) {
		$this->setOptions($config);
		
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
	
	public function setMerchantId($merchantid) {
		$this->config['merchant_id'] = $merchantid;
		
	}
	
	public function setMerchantKey($merchantkey) {
		$this->config['merchant_key'] = $merchantkey;
	}
	
	
	/**
	 * 
	 * 
	 * @param Item $item
	 * @return Order
	 */
	public function addItem(Item $item) {
		if (!$item->isValid()) {
			throw new Exception("You need to provide all the required options for the Item");
		}
		$this->_items[] = $item;
		return $this;
	}
	
	
	public function getRedirectUrl() {
		if (!count($this->_items)) {
			throw new Exception("You must add at least one item!");
		}
		
		$checkout = new \SimpleXMLElement("<?xml version='1.0' encoding='utf-8'?><checkout-shopping-cart></checkout-shopping-cart>");
		$checkout->addAttribute('xmlns', 'http://checkout.google.com/schema/2');
		$shopping_cart = $checkout->addChild('shopping-cart');
		$items = $shopping_cart->addChild('items');
		foreach ($this->_items as $item_obj) {
			$item = $items->addChild('item');
			$item->addChild('item-name', $item_obj->getName());
			$item->addChild('item-description', $item_obj->getDescription());
			$price = $item->addChild('unit-price', $item_obj->getPrice());
			$price->addAttribute('currency', 'USD');
			$item->addChild('quantity', $item_obj->getQuantity());
		}
		
		$xml = $checkout->asXML();
		
		$url = "https://{$this->config['merchant_id']}:{$this->config['merchant_key']}@sandbox.google.com/checkout/api/checkout/v2/merchantCheckout/Merchant/" . urlencode(trim($this->config['merchant_id']));
		
		$config = array(
			'adapter'		=> 'Zend_Http_Client_Adapter_Curl',
			'curloptions'	=> array(
				CURLOPT_FOLLOWLOCATION	=> true,
				CURLOPT_POST			=> true,
			),
		);
		
		$client = new \Zend_Http_Client($url, $config);
		$client->setHeaders('Content-Type', 'application/xml; charset=UTF-8');
		$client->setHeaders('Accept', 'application/xml; charset=UTF-8');
		
		$return = $client->setRawData($xml, 'text/xml')->request('POST')->getBody();
		
		$return = new \SimpleXMLElement($return);
		if (!isset($return->{'redirect-url'})) {
			throw new Exception("An Error has occurred");
		}
		$url = current($return->{'redirect-url'});
		return $url;
		
	}
	
	
	
	
	
	
	
	
}

