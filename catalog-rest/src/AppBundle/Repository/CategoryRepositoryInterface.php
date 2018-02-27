<?php

namespace AppBundle\Repository;

use AppBundle\Model\CategoryInterface;

interface CategoryRepositoryInterface extends RepositoryInterface
{
    /**
     * @param CategoryInterface         $category
     * @return                      mixed
     */
    public function refresh(CategoryInterface $category);

    /**
     * @param CategoryInterface         $category
     * @param array                 $arguments
     */
    public function save(CategoryInterface $category, array $arguments = []);

    /**
     * @param CategoryInterface         $category
     * @param array                 $arguments
     */
    public function delete(CategoryInterface $category, array $arguments = []);
}