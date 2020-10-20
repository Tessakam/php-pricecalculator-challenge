<?php


class CustomerLoader
{
private Customer $customer;

    public function __construct($customer)
    {
        $this->customer = $customer;
    }

    public function getAllmyCustomerGroup($pdo){
        $groupId=$this->customer->getGroupId();
        $handle = $pdo->prepare('SELECT parent_id FROM customer_group where id = :id');
        $handle->bindValue(':id',  $groupId);
        $handle->execute();
        $test = $handle->fetchAll();
        var_dump($test);
    }

    public function AddFixGroupDiscount(){
        //parameter is the array of Customer_Group
    }

    public function compareVariableGroupDiscount(){
        //parameter is the array of Customer_Group
    }

    public function globalVariableComparaison(){ }

    public function globalFixComparaison(){ }

    public function giveFinalDiscount(){ }


}