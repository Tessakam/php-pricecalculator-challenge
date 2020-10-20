<?php

declare(strict_types=1);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);


require '../Model/database.php';
require '../Model/Customer.php';
require '../Model/Product.php';
require '../Model/Customer_Group.php';
require '../config.php';
$pdo = openConnection($dbuser,$dbpass);


//$example_id=10;
//
//$handle = $pdo->prepare('SELECT id, firstname FROM customer where id = :id');
//$handle->bindValue(':id', $example_id);
//$handle->execute();
//$selectedProduct = $handle->fetch();
//
//var_dump($selectedProduct);

//This segment marks all the checkboxes with all the current sports for an existing user when you update him. Currently that is not working however. :-(

require '../View/view.php';
