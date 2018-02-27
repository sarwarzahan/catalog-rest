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
     * @param string $newName
     * @return ProductInterface
     */
    public function setName($newName);
}
