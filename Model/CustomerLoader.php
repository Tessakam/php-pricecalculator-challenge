<?php


class CustomerLoader
{
    private Customer $customer;

    public function __construct($customer)
    {
        $this->customer = $customer;
    }

    public function getAllmyCustomerGroup($pdo)
    {
        $customerGroupId = array();
        $groupId = $this->customer->getGroupId(); // Get the first Customer Group
        array_push($customerGroupId, $groupId);
        do {
            $handle = $pdo->prepare('SELECT parent_id  FROM customer_group where id = :id');
            $handle->bindValue(':id', $groupId);
            $handle->execute();
            $result = $handle->fetchAll();
            $groupId = $result[0]['parent_id'];
            if($groupId!=null){ array_push($customerGroupId, $groupId) ;}
        } while ($groupId != null);
        $customerObjectGroup = array();
        foreach ($customerGroupId as $id){
            $MyCustomerGroup=new Customer_Group($id,$pdo);
            array_push($customerObjectGroup,$MyCustomerGroup);
        }
        return $customerObjectGroup;// return array of Id of Group -> make it an array of customer Group

    }

    public function AddFixGroupDiscount()
    {
        //public function get_group_fixed_discount()
        //    {
        //        $group_id = $this->group_id;
        //        $sumFixedDiscount = $group_id->getFixedDiscount();
        //
        //        //loop
        //        while($group_id->getGroupId() !== null){
        //            $fixDiscountGroup = $group_id->getGroupId()->getFixedDiscount();
        //            $sumFixedDiscount += $fixDiscountGroup;
        //            $group_id = $group_id->getGroupId();
        //        }
        //        return $sumFixedDiscount;
        //    }
        //parameter is the array of Customer_Group
    }

    public function compareVariableGroupDiscount()
    {
        //parameter is the array of Customer_Group
    }

    public function globalVariableComparaison()
    {
    }

    public function globalFixComparaison()
    {
    }

    public function giveFinalDiscount()
    {
    }


}