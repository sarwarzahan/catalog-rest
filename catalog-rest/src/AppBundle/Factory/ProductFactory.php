<?php

namespace AppBundle\Factory;

use AppBundle\Entity\Product;

class ProductFactory implements ProductFactoryInterface
{
    /**
     * @param  string       $productName
     * @return Product
     */
    public function create($productName)
    {
        return new Product($productName);
    }
}
