<?php

namespace AppBundle\Model;

/**
 * Interface ProductInterface
 * @package AppBundle\Model
 */
interface ProductInterface
{
    /**
     * @return int|null
     */
    public function getId();

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     * @return ProductInterface
     */
    public function setName($name);
    
    /**
     * @return CategoryInterface
     */
    public function getCategory();

    /**
     * @param CategoryInterface $category
     * @return ProductInterface
     */
    public function setCategory($category);
    
    /**
     * @return string
     */
    public function getSku();
    
    /**
     * @param string $sku
     * @return ProductInterface
     */
    public function setSku($sku);
    
    /**
     * @return decimal
     */
    public function getprice();

    /**
     * @param decimal $price
     * @return ProductInterface
     */
    public function setPrice($price);
    
    /**
     * @return int
     */
    public function getQuantity();
    
    /**
     * @param int $quantity
     * @return ProductInterface
     */
    public function setQuantity($quantity);
}
