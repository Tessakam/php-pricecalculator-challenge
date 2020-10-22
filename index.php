<?php

declare(strict_types=1);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);


require 'Model/database.php';
require 'Model/Products.php';
require 'Model/Customers.php';
require 'Model/Customer.php';
require 'Model/Product.php';
require 'Model/Customer_Group.php';
require 'Model/CustomerLoader.php';
require 'Controller/homepage.php';


$controller = new HomepageController();

$controller->render($_GET, $_POST);