<?php


class CustomerLoader
{
    private Customer $customer;

    public function __construct($customer)
    {
        $this->customer = $customer;
    }

    // Get all information from database Customer Group for specific customer
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
            if ($groupId != null) {
                array_push($customerGroupId, $groupId);
            }
        } while ($groupId != null);
        $customerObjectGroup = array();

        foreach ($customerGroupId as $id) {
            $MyCustomerGroup = new Customer_Group($id, $pdo);
            array_push($customerObjectGroup, $MyCustomerGroup);
        }
        return $customerObjectGroup;// return array of Id of Group -> make it an array of customer Group
    }

    // Get all fixed discounts from the customer group
    public function AddFixGroupDiscount($customerGroup)
    {
        $arrayFixedDiscount = array();
        $sumFixedDiscount = 0;

        foreach ($customerGroup as $objectGroup) {
            $fixedDiscount = $objectGroup->getFixedDiscount();
            $groupName = $objectGroup->getName();
            if ($fixedDiscount != null) {
                $arrayDiscount = array('name' => $groupName, 'discount' => $fixedDiscount);
                array_push($arrayFixedDiscount, $arrayDiscount);
                $sumFixedDiscount += intval($fixedDiscount);
            }
        }
        // combines the discount of different groups (example 5euro of marketing and 2euro of becode)
        $allFixedInfo = array('details' => $arrayFixedDiscount, 'total' => $sumFixedDiscount);
        return ($allFixedInfo);
    }

    public function compareVariableGroupDiscount($customerGroup)
    {
        $arrayVariableDiscount = array();

        foreach ($customerGroup as $objectGroup) {

            $variableDiscount = intval($objectGroup->getVariableDiscount());
            $variableName = $objectGroup->getName();
            if ($variableDiscount != null) {
                $arrayDiscount = array('name' => $variableName, 'discount' => $variableDiscount);
                array_push($arrayVariableDiscount, $arrayDiscount);
            }
        }

        // looping to get the highest discount
        if (count($arrayVariableDiscount) > 1) {
            $arrayDiscount = $arrayVariableDiscount[0];
            foreach ($arrayVariableDiscount as $objectDiscount) {
                if ($objectDiscount['discount'] > $arrayDiscount['discount']) {
                    $arrayDiscount = $objectDiscount;
                }
            }
        } elseif (!empty($arrayVariableDiscount)) {
            $arrayDiscount = $arrayDiscount = $arrayVariableDiscount[0];
        } else {
            $arrayDiscount = array('name' => 'No variable Discount', 'discount' => 0);
        }

        return $arrayDiscount;

    }

    public function groupDiscountcomparaison($normalPrice, $fixedGroupDiscount, $variableGroupDiscount)
    {
        $priceFixedDiscount = $normalPrice - $fixedGroupDiscount;

        if ($variableGroupDiscount != 0) {
            $priceVariableDiscount = $normalPrice - ($normalPrice * $variableGroupDiscount) / 100;
        } else {
            $priceVariableDiscount = $normalPrice;
        }
        if ($priceFixedDiscount < $priceVariableDiscount) {
            return $bestDiscount = $fixedGroupDiscount;
        } else {
            return $bestDiscount = FLOOR($variableGroupDiscount) . '%';
        }
    }

    //false = percentage and true = fixed discount
    public function getFinalVariableDiscount($finalGroupDiscount, $VariableGroupDiscount)
    {
        if ($this->customer->getVariableDiscount() != null && is_numeric($finalGroupDiscount) == false) {
            if ($this->customer->getVariableDiscount() < $VariableGroupDiscount) {
                $finalVariableDiscount = $VariableGroupDiscount;
            } else  $finalVariableDiscount = $this->customer->getVariableDiscount();
        } elseif ($this->customer->getVariableDiscount() == null && is_numeric($finalGroupDiscount) == false) {
            $finalVariableDiscount = $VariableGroupDiscount;
        } elseif ($this->customer->getVariableDiscount() != null && is_numeric($finalGroupDiscount) == true) {
            $finalVariableDiscount = $this->customer->getVariableDiscount();
        } else {
            $finalVariableDiscount = 0;
        }

        return $finalVariableDiscount;
    }

    public function getFinalFixedDiscount($finalGroupDiscount)
    {
        if ($this->customer->getFixedDiscount() != null && is_numeric($finalGroupDiscount) == true) {
            $finalFixedDiscount = $this->customer->getFixedDiscount() + $finalGroupDiscount;
        } elseif ($this->customer->getFixedDiscount() != null && is_numeric($finalGroupDiscount) == false) {
            $finalFixedDiscount = $this->customer->getFixedDiscount();
        } elseif ($this->customer->getFixedDiscount() == null && is_numeric($finalGroupDiscount) == true) {
            $finalFixedDiscount = $finalGroupDiscount;
        } else {
            $finalFixedDiscount = 0;
        }
        return $finalFixedDiscount;
    }


    public function giveFinalPrice($normalPrice, $finalFixedDiscount, $finalVariableDiscount)
    {
        $finalPrice = $normalPrice - $finalFixedDiscount - ($normalPrice - $finalFixedDiscount) * $finalVariableDiscount / 100;
        if ($finalPrice <= 0) {
            $finalPrice = 0;
            //$message = "Congratulation, you have enough points on your card, you get a free product !";
        }
        return number_format((float)$finalPrice, 2, '.', '') . '€';
    }


}