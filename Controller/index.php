<?php

declare(strict_types=1);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);


require '../Model/database.php';

require '../config.php';
$pdo = openConnection($dbuser,$dbpass);



require '../View/view.php';
