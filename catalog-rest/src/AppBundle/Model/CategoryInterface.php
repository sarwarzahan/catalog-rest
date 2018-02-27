<?php

namespace AppBundle\Model;

/**
 * Interface CategoryInterface
 * @package AppBundle\Model
 */
interface CategoryInterface
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
