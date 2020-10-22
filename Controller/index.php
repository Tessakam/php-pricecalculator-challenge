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

    $price = $_SESSION["product"]->getPrice();
    $normalPrice = $_SESSION["product"]->getNormalPrice();

    $loader = new CustomerLoader($_SESSION["customer"]);
    $customerGroup = $loader->getAllmyCustomerGroup($pdo);

    // --------------------get Best Group Variable Discount

    $VariableGroup = $loader->compareVariableGroupDiscount($customerGroup);
    $VariableGroupDiscount = $VariableGroup['discount'];
    $VariableGroupName = $VariableGroup['name'];

    // --------------------get Best Fixed Variable Discount

    $FixedGroup = $loader->AddFixGroupDiscount($customerGroup);
    $FixedGroupDiscount = $FixedGroup['total'];

    $messageFixedGroupDiscount = '';
    if (empty($FixedGroup['details'])) {
        $messageFixedGroupDiscount = 'You get no fixed Discount from your Customer Groups.';
    } elseif (count($FixedGroup['details']) == 1) {
        $messageFixedGroupDiscount = 'You get ' . $FixedGroup['details'][0]['discount'] . '€ discount, because you are part of : ' . $FixedGroup['details'][0]['name'] . '.';
    } else {
        foreach ($FixedGroup['details'] as $array) {
            $messageFixedGroupDiscount .= 'As a member of ' . $array['name'] . ' , you get ' . $array['discount'] . ' € of discount.<br>';
        }
        $messageFixedGroupDiscount .= ' In total you get ' . $FixedGroupDiscount . ' € of discount from your customer groups.';
    }

// --------------------get Final Group discount and message


    $finalGroupDiscount = $loader->groupDiscountcomparaison($normalPrice, $FixedGroupDiscount, $VariableGroupDiscount);

    if (is_numeric($finalGroupDiscount) == false) {
        $finalGroupMessage = 'As a member of ' . $VariableGroupName . ' , you get ' . $VariableGroupDiscount . '% discount.';
    } else {
        $finalGroupMessage = $messageFixedGroupDiscount;
    }

    // --------------------get Final Variable Discount + message

    // Variable value :
    $finalVariableDiscount = $loader->getFinalVariableDiscount($finalGroupDiscount, $VariableGroupDiscount);

    // Message for variable :
    if ($finalVariableDiscount == 0 || $finalVariableDiscount == null) {
        $finalVariableMessage = "You don't have any variable discount.";
    } elseif ($finalVariableDiscount == $VariableGroupDiscount) {
        $finalVariableMessage = $finalGroupMessage;
    } else {
        $finalVariableMessage = 'You get ' . $_SESSION["customer"]->getVariableDiscount() . ' % discount from your customer advantages.';
    }



    // --------------------get Final Fixed Discount + message

    // Fixed value :

    $finalFixedDiscount = $loader->getFinalFixedDiscount($finalGroupDiscount);

    // Fixed message :

    $finalFixedMessage="";
    if($FixedGroupDiscount == $finalGroupDiscount && $_SESSION["customer"]->getFixedDiscount()!=null ){
        $finalFixedMessage=$finalGroupMessage. '<br>From your customer advantages you benefit from '. $_SESSION["customer"]->getFixedDiscount().'€ discount.';
    }
    elseif ($_SESSION["customer"]->getFixedDiscount()!=null){  $finalFixedMessage='From your customer advantages you benefit from '. $_SESSION["customer"]->getFixedDiscount().'€ discount.'; }


    // --------------------get Final Price + message

    $finalPrice = $loader->giveFinalPrice($normalPrice, $finalFixedDiscount, $finalVariableDiscount);

    $finalMessage= $finalVariableMessage.'<br>'.$finalFixedMessage.'<br>The final price is '.$finalPrice.' .';

    echo  $finalMessage;

}


require '../View/view.php';
