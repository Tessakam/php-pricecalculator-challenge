<?php


class Product
{
    private string $name;
    private int $id, $price;

    public function __construct($name, $id, $price)
    {
        $this->name = $name;
        $this->id = $id;
        $this->price = $price;
    }


    public function getName()
    {
        return $this->name;
    }


    public function getId()
    {
        return $this->id;
    }


    public function getPrice()
    {
        return $this->price;
    }

    public function getNormalPrice()
    {
        return $this->price/100;
    }




}