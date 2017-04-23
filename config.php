<?php

function my_autoloader($customer) {
	include 'classes/class.'.$customer.'.php';
}

spl_autoload_register('my_autoloader');

// Connecting to the MySQL database
$user = 'kirtmand1';
$password ='Jw8zNa8U';
$database = new PDO('mysql:host=csweb.hh.nku.edu;dbname=db_spring17_kirtmand1', $user, $password);
$cartArray=array();
// Start the session
session_start();
$cart = &$_SESSION['cart'];
$current_url = basename($_SERVER['REQUEST_URI']);

// if customerID is not set in the session and current URL not login.php redirect to login page
if (!isset($_SESSION["customerID"]) && $current_url != 'login.php') {
    header("Location: login.php");
}

// Else if session key customerID is set get $customer from the database
elseif (isset($_SESSION["customerID"])) {
	$customer = new Customer($_SESSION["customerID"], $database);
}

// Else if session key customerID is set get $customer from the database
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = new ShoppingCart($cartArray);
	
}