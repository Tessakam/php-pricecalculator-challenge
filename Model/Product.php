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


}