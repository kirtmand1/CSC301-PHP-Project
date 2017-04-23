<?php

class Customer{
	private $name;
	private $ID;
	
	public function __construct($customerID, $database) {

		$sql = file_get_contents('sql/getCustomer.sql');
		$params = array(
			'customerid' => $customerID
		);
		$statement = $database->prepare($sql);
		$statement->execute($params);
		$customers = $statement->fetchAll(PDO::FETCH_ASSOC);
		
		$customer_info = $customers[0];
		$this->name = $customer_info['name'];
		$this->id = $customer_info['customerid'];
	}
	
	public function getName() {
		return $this->name;
	}
}
