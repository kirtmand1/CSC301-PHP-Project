<?php

class ShoppingCart implements iterator{	
	private $myArray;
	
	public function __construct($cart) {
		$this->myArray = $cart;
	}
		
	function rewind() {
		return reset($this->myArray);
	}
	
	function current() {
		return current($this->myArray);
	}
	
	function key() {
		return key($this->myArray);
	}
	
	function next() {
		return next($this->myArray);
	}
  
	function valid() {
		return key($this->myArray) !== null;
	}	
	
	public function addToCart($item, $sku) {
		$this->myArray[$item]=$sku;
	}
	
}