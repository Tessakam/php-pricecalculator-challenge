<?php


class Customers
{ /** @var array Customer[] */
    private array $customers;

    public function __construct($pdo)
    { $arrayCustomers = array();
        $getCustomers = $pdo->prepare("SELECT * FROM customer ORDER BY lastname ASC");
        $getCustomers->execute();
        $customers = $getCustomers->fetchAll();

        foreach ($customers as $customer) {
            $customer=new Customer($customer['firstname'], $customer['lastname'], $customer['id'], $customer['fixed_discount'], $customer['variable_discount'], $customer['group_id']);
            array_push($arrayCustomers,$customer);
        }
        $this->customers=$arrayCustomers;
    }

    public function getCustomers()
    {
        return $this->customers;
    }

}