<?php


class Customer_Group
{  ///** @var array Customer[] */
   // private array customers;
private string $name;
private int $fixed_discount, $variable_discount, $id;

public function __construct($name, $fixed_discount, $variable_discount, $id)
{
    $this->name = $name;
    $this->fixed_discount = $fixed_discount;
    $this->variable_discount = $variable_discount;
    $this->id = $id;
}

}