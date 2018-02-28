<?php

namespace AppBundle\Factory;

use AppBundle\Entity\Product;

interface ProductFactoryInterface
{
    /**
     * @param  string       $productName
     * @return Product
     */
    public function create($productName);
}