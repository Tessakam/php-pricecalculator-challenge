<?php

declare(strict_types=1);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

class Customer_Group
{
    private string $name,$id;
    private $variable_discount, $fixed_discount, $parent_id;

    public function __construct($id, $pdo)
    {
        $handle = $pdo->prepare('SELECT * FROM customer_group where id = :id');
        $handle->bindValue(':id', $id);
        $handle->execute();
        $result = $handle->fetchAll();

        $this->name = $result[0]['name'];
        $this->fixed_discount = $result[0]['fixed_discount'];
        $this->variable_discount = $result[0]['variable_discount'];
        $this->id = $id;
        $this->parent_id = $result[0]['parent_id'];
    }

    public function getParentId()
    {
        return $this->parent_id;
    }


    public function getFixedDiscount()
    {
        return $this->fixed_discount;
    }


    public function getVariableDiscount()
    {
        return $this->variable_discount;
    }


    public function getName()
    {
        return $this->name;
    }


    public function getId()
    {
        return $this->id;
    }


}