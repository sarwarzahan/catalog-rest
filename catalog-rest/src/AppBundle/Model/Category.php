<?php

namespace AppBundle\Model;

use AppBundle\Model\CategoryInterface;

/**
 * Class Category
 * @package AppBundle\Model
 */
class Category implements CategoryInterface
{
    private $name;

    /**
     * Category constructor.
     * 
     * @param string $name
     */
    private function __construct($name)
    {
        $this->name = $name;
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
}
