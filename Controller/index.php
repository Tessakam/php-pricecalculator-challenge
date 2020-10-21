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

$pdo = openConnection($dbuser, $dbpass);

session_start();

if (!isset($_SESSION["customer"])) {
    $_SESSION["customer"] = "";
}
if (!isset($_SESSION["product"])) {
    $_SESSION["product"] = "";
}


//_______________________ Get Products

$getProducts = $pdo->prepare("SELECT * FROM product ORDER BY name ASC");
$getProducts->execute();
$products = $getProducts->fetchAll();

foreach ($products as $product) {
    if (isset($_GET['productDropdown']) && $_GET['productDropdown'] == $product['id']) {
        $_SESSION["product"] = new product($product['name'], $product['id'], $product['price']);

    }
}


//_______________________ Get Customers

$getCustomers = $pdo->prepare("SELECT * FROM customer ORDER BY lastname ASC");
$getCustomers->execute();
$customers = $getCustomers->fetchAll();

foreach ($customers as $customer) {
    if (isset($_GET['customerDropdown']) && $_GET['customerDropdown'] == $customer['id']) {
        $_SESSION["customer"] = new Customer($customer['firstname'], $customer['lastname'], $customer['id'], $customer['fixed_discount'], $customer['variable_discount'], $customer['group_id']);

    }
}

//_______________________ When submit


if (isset($_POST["submit"])) {

    var_dump($_SESSION["customer"]);
    $price = $_SESSION["product"]->getPrice();
    $normalPrice = $_SESSION["product"]->getNormalPrice();

    $loader = new CustomerLoader($_SESSION["customer"]);
    $customerGroup = $loader->getAllmyCustomerGroup($pdo);

    $VariableGroupDiscount = $loader->compareVariableGroupDiscount($customerGroup);

    $FixedGroupDiscount = $loader->AddFixGroupDiscount($customerGroup);

<<<<<<< HEAD
<<<<<<< HEAD
}




=======
var_dump($finalFixedDiscount);
var_dump($_SESSION["product"]);
$finalPrice=$normalPrice-$finalFixedDiscount-($normalPrice-$finalFixedDiscount)*$finalVariableDiscount/100;
if($finalPrice<=0){$finalPrice=0; $message="Congratulation, you have enough points on your card, you get a free product !";}
echo $finalPrice;
=======
    $finalGroupDiscount = $loader->groupDiscountcomparaison($normalPrice, $FixedGroupDiscount, $VariableGroupDiscount);

    // --------------------get Final Variable Discount
    $finalVariableDiscount = $loader->getFinalVariableDiscount($finalGroupDiscount, $VariableGroupDiscount);

    // --------------------get Final Fixed Discount
    $finalFixedDiscount=$loader->getFinalFixedDiscount($finalGroupDiscount);

    // --------------------get Final Price

    $finalPrice=$loader->giveFinalPrice($normalPrice, $finalFixedDiscount,$finalVariableDiscount);


var_dump( $_SESSION["product"]);
    echo $finalPrice;
>>>>>>> 62530126078159a0bd556f88ae15eb1497963e3f

}


>>>>>>> 30352061ff33c526e21e28af49edcc32c2018ddc
require '../View/view.php';
