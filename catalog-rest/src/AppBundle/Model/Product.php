<?php

namespace AppBundle\Model;

use AppBundle\Model\ProductInterface;

/**
 * Class Product
 * @package AppBundle\Model
 */
class Product implements ProductInterface
{
    private $name;
    private $category;
    private $sku;
    private $price;
    private $quantity;

    /**
     * Product constructor.
     * 
     * @param string $name
     * @param string $category
     * @param string $sku
     * @param decimal $price
     * @param int $quantity
     */
    private function __construct($name, $category, $sku, $price, $quantity)
    {
        $this->name = $name;
        $this->category = $category;
        $this->sku = $sku;
        $this->price = $price;
        $this->quantity = $quantity;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return string
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }
}
