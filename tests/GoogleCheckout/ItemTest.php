<?php

namespace GoogleCheckout;

class ItemTest extends \PHPUnit_Framework_TestCase {
	
	protected $_item;

	public function setUp() {
		$this->_item = new Item();
	}	
	
	public function tearDown() {
		
	}


	public function testCanAddPrice() {
		$this->_item->setPrice('20');
		$this->assertEquals($this->_item->getPrice(), '20');
	}
	
}

