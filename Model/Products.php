<?php


class Products
{
/** @var array Product[] */
    private array $products;

    public function __construct($pdo)
    {
        $arrayProduct = array();
        $getProducts = $pdo->prepare("SELECT * FROM product ORDER BY name ASC");
        $getProducts->execute();
        $products = $getProducts->fetchAll();
        foreach ($products as $product) {
            $product = new product($product['name'], $product['id'], $product['price']);
            array_push($arrayProduct,$product);
        }
        $this->products=$arrayProduct;
    }

    public function getProducts()
    {
        return $this->products;
    }
}


