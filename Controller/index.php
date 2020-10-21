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

$getProducts = $pdo->prepare("SELECT * FROM product ORDER BY id ASC");
$getProducts->execute();
$products = $getProducts->fetchAll();

foreach ($products as $product) {
    if (isset($_GET['productDropdown']) && $_GET['productDropdown'] == $product['id']) {
        $_SESSION["product"] = new product($product['name'], $product['id'], $product['price']);

    }
}


//_______________________ Get Customers

$getCustomers = $pdo->prepare("SELECT * FROM customer ORDER BY id ASC");
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
    //var_dump($_SESSION["product"]);
    $price = $_SESSION["product"]->getPrice();
    $normalPrice=$_SESSION["product"]->getNormalPrice();
    //echo $price;

    $loader = new CustomerLoader($_SESSION["customer"]);
    //from here modifications
    $customerGroup = $loader->getAllmyCustomerGroup($pdo); //need to put $pdo as a parameter if not won't work
    // now we have all the Customer_group of our customer, need to compare them
    // ->getHighestVariableDiscount from the array $ customerGroup
    // -> make an addition of the fixDiscount if not null
    //Compare with the customer->getFixedDiscount() , and customer ->getVariableDiscount()
    //Get the final price
    var_dump($customerGroup);

    //After morning break, changes from here
    $VariableGroupDiscount = $loader->compareVariableGroupDiscount($customerGroup);
    $FixedGroupDiscount = $loader->AddFixGroupDiscount($customerGroup);
    $finalGroupDiscount = $loader->groupDiscountcomparaison($_SESSION["product"]->getNormalPrice(), $FixedGroupDiscount, $VariableGroupDiscount);
    var_dump( $finalGroupDiscount);
//var_dump(is_numeric($finalGroupDiscount));

  if($_SESSION["customer"]->getVariableDiscount()!=null && is_numeric($finalGroupDiscount)==false){
      if ($_SESSION["customer"]->getVariableDiscount()<$VariableGroupDiscount){
          $finalVariableDiscount=$VariableGroupDiscount;
      }
      else  $finalVariableDiscount=$_SESSION["customer"]->getVariableDiscount();
  }
  elseif($_SESSION["customer"]->getVariableDiscount()==null && is_numeric($finalGroupDiscount)==false){
      $finalVariableDiscount=$VariableGroupDiscount;
  }
  elseif($_SESSION["customer"]->getVariableDiscount()!=null && is_numeric($finalGroupDiscount)==true){
      $finalVariableDiscount=$_SESSION["customer"]->getVariableDiscount();
  }
  else{$finalVariableDiscount=0;}

  var_dump($finalVariableDiscount);

//-------------------- Fixed
if($_SESSION["customer"]->getFixedDiscount()!=null && is_numeric($finalGroupDiscount)==true)
{ $finalFixedDiscount= $_SESSION["customer"]->getFixedDiscount()+$finalGroupDiscount;}
elseif($_SESSION["customer"]->getFixedDiscount()!=null && is_numeric($finalGroupDiscount)==false){
    $finalFixedDiscount= $_SESSION["customer"]->getFixedDiscount();
}
elseif($_SESSION["customer"]->getFixedDiscount()==null && is_numeric($finalGroupDiscount)==true){
    $finalFixedDiscount= $finalGroupDiscount;
}
else{ $finalFixedDiscount=0;}

var_dump($finalFixedDiscount);
var_dump($_SESSION["product"]);
$finalPrice=$normalPrice-$finalFixedDiscount-($normalPrice-$finalFixedDiscount)*$finalVariableDiscount/100;
if($finalPrice<=0){$finalPrice=0; $message="Congratulation, you have enough points on your card, you get a free product !";}
echo $finalPrice;

}


require '../View/view.php';
