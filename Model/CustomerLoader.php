<?php


class CustomerLoader
{
private Customer $customer;

    public function __construct(array $customers)
    {
        $this->customers = $customers;
    }

    function getAllmyCustomerGroup($customer){
        //->get group ID => and then go the data base Customer group
        //make a new customer group
        //from it I am gonna check if there is a parent ID
        //I am gonna loop inside until Parent ID =Null
        //each time I will push my Group ID in my array of customer Groups
//return depend of existence of ID parents
        //return an array of  all id of Customer_Group which should be object Customer_Group
    }

    function AddFixGroupDiscount(){
        //parameter is the array of Customer_Group
    }

    function compareVariableGroupDiscount(){
        //parameter is the array of Customer_Group
    }

    function globalVariableComparaison(){ }

    function globalFixComparaison(){ }

    function giveFinalDiscount(){ }


}