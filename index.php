<?php

declare(strict_types=1);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

//include all your model files here
require 'Model/Database.php';
require 'Model/Products.php';
require 'Model/Customers.php';
require 'Model/Customer.php';
require 'Model/Product.php';
require 'Model/Customer_Group.php';
require 'Model/CustomerLoader.php';
//include all your controller files here
require 'Controller/Homepage.php';

$controller = new HomepageController();

// Loads the view - Allows templating and then sending an array of data into the view.
$controller->render($_GET, $_POST);