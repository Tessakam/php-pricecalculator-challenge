<?php

class Customer
{
    private string $id, $firstname, $lastname;
    private $variable_discount, $fixed_discount;
    private $group_id;

    public function __construct($firstname, $lastname, $id, $fixed_discount, $variable_discount, $group_id)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->id = $id;
        $this->fixed_discount = $fixed_discount;
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

    public function getId(): string
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

}