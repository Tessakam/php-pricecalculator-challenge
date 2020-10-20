<?php


class Customer
{
    private string $firstname, $lastname;
    private int $id, $fixed_discount, $variable_discount;
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


}