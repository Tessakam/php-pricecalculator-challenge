<?php

declare(strict_types=1);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

class Customer
{
    private string $firstname, $lastname;
    private int $id, $fixed_discount;
    private $variable_discount;
    private $group_id;

    public function __construct($firstname, $lastname, $id, $fixed_discount, $variable_discount, $group_id)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->id = $id;
        $this->fixed_discount = $fixed_discount * 100;
        $this->variable_discount = $variable_discount;
        $this->group_id = $group_id;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getGroupId()
    {
        return $this->group_id;
    }

    public function getFixedDiscount() // float|int
    {
        return $this->fixed_discount;
    }

    public function getVariableDiscount() // mixed
    {
        return $this->variable_discount;
    }


    public function getDiscount($price)
    {
        //return name
        return $this->firstname;

        //return discount

    }
}