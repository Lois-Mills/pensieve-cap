<?php
include_once("../classes/user_class.php");



function registerUser_ctr($username, $email, $password){
	$adduser=new user_class();
	$result = $adduser->registerUser($username, $email, $password);
	return $result;
}


function loginUser_ctr($username, $password) {
	$loginClass = new user_class();
	$result = $loginClass->loginUser($username, $password);
    return $result;
}


function get_customers_controller() {
    $newProduct = new user_class();
    return $newProduct->viewAllCustomers();
} 


 
  

















