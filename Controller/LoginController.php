<?php
declare(strict_types=1);


class LoginController{

    public function render(array $GET, array $POST){

        require 'config.php';
        $pdo = openConnection($dbuser, $dbpass);

        session_start();


        require 'View/login.php';
    }






}