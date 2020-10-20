<?php


class Customer_Group
{
private string $name;
private int $fixed_discount, $id, $parent_id;
private  $variable_discount;

public function __construct($name, $fixed_discount, $variable_discount, $id, $parent_id)
{
    $this->name = $name;
    $this->fixed_discount = $fixed_discount;
    $this->variable_discount = $variable_discount;
    $this->id = $id;
}

    public function getParentId()
    {
        return $this->parent_id;
    }


    public function get_group_variable_discount (){

    }

    public function get_group_fixed_discount (){

    }
    
    
    

}