<?php

namespace GoogleCheckout;

class OrderTest extends \PHPUnit_Framework_TestCase {

	protected $_order;
	protected $_item;

	public function setUp() {
		$this->_order = new Order();
		$this->_item = new Item();
		$this->_item->setPrice('20.20');
		$this->_item->setName('testname');
		$this->_item->setDescription('testdescription');
		$this->_item->setQuantity(100);
		$this->assertTrue($this->_item->isValid());
	}

	public function tearDown() {
		
	}


	public function testCanAddItemToOrder() {
		$this->_order->addItem($this->_item);
		$items = $this->_order->getItems();
		$this->assertArrayHasKey(0, $items);
		$this->assertInstanceOf('GoogleCheckout\Item', $items[0]);
	}

	
}

