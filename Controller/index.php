<?php

declare(strict_types=1);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);


require '../Model/database.php';
require '../Model/Customer.php';
require '../Model/Product.php';
require '../Model/Customer_Group.php';
require '../Model/CustomerLoader.php';
require '../config.php';

$pdo = openConnection($dbuser,$dbpass);

session_start();

if (!isset($_SESSION["customer"])) {
    $_SESSION["customer"] = "";
}
if (!isset($_SESSION["product"])) {
    $_SESSION["product"] = "";
}


//_______________________ Get Products

$getProducts = $pdo->prepare("SELECT * FROM product ORDER BY id ASC");
$getProducts->execute();
$products = $getProducts->fetchAll();

foreach ($products as $product){
    if (isset($_GET['productDropdown']) && $_GET['productDropdown']==$product['id']){
        $_SESSION["product"] =new product($product['name'],$product['id'],$product['price']);

    }
}


//_______________________ Get Customers

$getCustomers = $pdo->prepare("SELECT * FROM customer ORDER BY id ASC");
$getCustomers->execute();
$customers = $getCustomers->fetchAll();

foreach ($customers as $customer){
    if (isset($_GET['customerDropdown']) && $_GET['customerDropdown']==$customer['id']){
        $_SESSION["customer"] =new Customer($customer['firstname'],$customer['lastname'],$customer['id'],$customer['fixed_discount'],$customer['variable_discount'],$customer['group_id']);

    }}

//_______________________ When submit

if (isset($_POST["submit"])){

    var_dump( $_SESSION["customer"] );
    var_dump($_SESSION["product"]);
    $price=$_SESSION["product"]->getPrice();
    echo $price;

    $loader=new CustomerLoader( $_SESSION["customer"]);
    $loader->getAllmyCustomerGroup($pdo); //need to put $pdo as a parameter if not won't work

}




require '../View/view.php';
