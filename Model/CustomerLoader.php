<?php


class CustomerLoader
{
/** @var array Customer[] */
    private array $customers;




    public function __construct(array $customers)
    {
        $this->customers = $customers;
    }

public function get_fixed_discount(){};

    public function get_variable_discount(){};

    public function get_group_variable_discount(){};

    public function get_group_fixed_discount(){};

    public function compareDiscount(){};

}