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

    public function AddFixGroupDiscount($customerGroup)
    {
        $sumFixedDiscount = 0;
        foreach ($customerGroup as $objectGroup) {
            $fixedDiscount = $objectGroup->getFixedDiscount();

            if ($fixedDiscount != null) {
                $sumFixedDiscount += intval($fixedDiscount);
            }
        }
        return $sumFixedDiscount;
    }
    public function compareVariableGroupDiscount($customerGroup )
    {
        $arrayVariableDiscount=array();
        foreach ($customerGroup as $objectGroup){
            $variableDiscount=$objectGroup->getVariableDiscount();
            if ($variableDiscount != null){array_push($arrayVariableDiscount,intval($variableDiscount));}

        }
        var_dump( $arrayVariableDiscount);
        if(count($arrayVariableDiscount)>1){
            $discount= max($arrayVariableDiscount);
        }
        elseif(!empty($arrayVariableDiscount)){
            $discount=intval(array_values($arrayVariableDiscount));
        }
        else{$discount=0;}
        return $discount;

    }

    public function groupDiscountcomparaison ($normalPrice,$fixedGroupDiscount,$variableGroupDiscount)
    {
        $priceFixedDiscount= $normalPrice-$fixedGroupDiscount;

        if($variableGroupDiscount!=0){$priceVariableDiscount=$normalPrice-($normalPrice*$variableGroupDiscount)/100;}
        else{$priceVariableDiscount=$normalPrice;}
     if ($priceFixedDiscount<$priceVariableDiscount){
         return $bestDiscount = $fixedGroupDiscount;
     }
       else {return $bestDiscount =FLOOR($variableGroupDiscount).'%';}
    }

    public function globalFixComparaison()
    {
    }

    public function giveFinalDiscount()
    {
    }


}